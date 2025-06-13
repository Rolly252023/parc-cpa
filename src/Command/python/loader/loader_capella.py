import pandas as pd
import unicodedata
from datetime import datetime
from sqlalchemy.orm import Session
from models.model_capella import Capella
import logging

logger = logging.getLogger("capella_loader")


class LoaderCapella:
    def __init__(self, session: Session):
        self.session = session

    def _slugify(self, col: str) -> str:
        nfkd = unicodedata.normalize("NFKD", col)
        ascii_only = nfkd.encode("ASCII", "ignore").decode("ASCII")
        return (
            ascii_only.strip()
            .lower()
            .replace(" ", "_")
            .replace("-", "_")
            .replace("'", "_")
        )

    def _convert_date(self, val: str):
        if not val or pd.isna(val) or not val.strip():
            return None
        for fmt in ("%d/%m/%Y", "%Y-%m-%d"):
            try:
                return datetime.strptime(val.strip(), fmt)
            except ValueError:
                continue
        return None

    def load_csv(self, file_path: str) -> bool:
        try:
            logger.info(f"Chargement du fichier CSV : {file_path}")
            df = pd.read_csv(
                file_path,
                sep=";",
                dtype=str,
                encoding="cp1252",
                skipinitialspace=True,
                engine="python",
            )
            original_cols = list(df.columns)
            logger.debug(f"Colonnes brutes importees : {original_cols}")

            df.columns = [self._slugify(c) for c in df.columns]
            slugged_cols = list(df.columns)
            logger.info(f"Colonnes normalisees : {slugged_cols}")

            df.fillna("", inplace=True)
            records = df.to_dict(orient="records")
            logger.info(f"Nombre de lignes lu: {len(records)}")

            existing = {
                obj.dossier: obj.id
                for obj in self.session.query(Capella.dossier, Capella.id)
            }
            logger.info(f"Nombre de dossiers existants en base: {len(existing)}")

            inserts = []
            updates = []
            now = datetime.now()

            for idx, row in enumerate(records, start=1):
                dossier = row.get("n_de_dossier")
                if not dossier:
                    logger.warning(f"Ligne {idx} ignoree: champ 'dossier' vide.")
                    continue

                # logger.debug(f"Traitement ligne {idx}, dossier={dossier}")
                common = {
                    "statut": row.get("statut_du_dossier"),
                    "date_creation": self._convert_date(row.get("date_de_creation")),
                    "titre": row.get("titre_du_dossier"),
                    "createur": row.get("cree_par_prenom_nom"),
                    "entity_suivi": row.get("entite_de_suivi"),
                    "bureau_suivi": row.get("bureau_de_suivi"),
                    "date_cloture": self._convert_date(row.get("date_de_cloture")),
                    "canal_echange": row.get("canal_du_premier_echange"),
                    "sens_canal": row.get("sens_du_canal"),
                    "identifiant": row.get("identifiant_(prm/siret/siren/grp)"),
                    "segment": row.get("segment_technique"),
                    "client": row.get("denomination_client"),
                    "code_insee": row.get("code_insee"),
                    "processus": row.get("processus"),
                    "type": row.get("type"),
                    "sous_type": row.get("sous_type"),
                    "nni_cloture": row.get("cloture_par_nni"),
                    "nom_cloture": row.get("cloture_par_prenom_nom"),
                    "bureau_traitement": row.get("bureau_de_traitement"),
                }

                if dossier in existing:
                    updates.append(
                        {"id": existing[dossier], **common, "created_at": now}
                    )
                else:
                    inserts.append({"dossier": dossier, **common, "created_at": now})

            logger.info(f"A preparer: {len(inserts)} inserts, {len(updates)} updates")

            if inserts:
                self.session.bulk_insert_mappings(Capella, inserts)
                logger.info(f"Inserts effectues: {len(inserts)}")
            if updates:
                self.session.bulk_update_mappings(Capella, updates)
                logger.info(f"Updates effectues: {len(updates)}")

            self.session.commit()
            logger.info("Import Capella termine avec succes.")
            return True

        except Exception as e:
            logger.exception(f"Erreur pendant l'upsert bulk Capella: {e}")
            self.session.rollback()
            return False
