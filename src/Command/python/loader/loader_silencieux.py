# src/Command/python/services/loader_silencieux.py

import pandas as pd
import unicodedata
from datetime import datetime
from sqlalchemy.orm import Session
from sqlalchemy import update
from models.model_silencieux import Silencieux
import logging

logger = logging.getLogger("silencieux_loader")

class LoaderSilencieux:
    """Charge le CSV Silencieux et fait un bulk upsert avec gestion d'état_silence."""
    def __init__(self, session: Session):
        self.session = session

    def _slugify(self, col: str) -> str:
        nfkd = unicodedata.normalize("NFKD", col)
        ascii_only = nfkd.encode("ASCII", "ignore").decode("ASCII")
        return (ascii_only.strip().lower()
                 .replace(" ", "_").replace("-", "_").replace("'", "_"))

    def _convert_date(self, val: str):
        if not val or pd.isna(val) or not val.strip():
            return None
        for fmt in ("%d/%m/%Y %H:%M:%S", "%d/%m/%Y"):
            try:
                return datetime.strptime(val.strip(), fmt)
            except ValueError:
                continue
        return None

    def load_csv(self, file_path: str) -> bool:
        try:
            # 1) Lecture et normalisation des en-têtes
            df = pd.read_csv(
                file_path,
                sep=";",
                dtype=str,
                encoding="cp1252",
                skipinitialspace=True,
                engine="python"
            )
            df.columns = [self._slugify(col) for col in df.columns]
            df.fillna("", inplace=True)

            # 2) Collecte des PRM importés
            imported_prms = set(df["prm"].tolist())
            now = datetime.now()

            # 3) Archiver les silenciés non ré-importés
            if imported_prms:
                stmt = (
                    update(Silencieux)
                    .where(
                        Silencieux.prm.notin_(imported_prms),
                        Silencieux.etat_silence != "archive"
                    )
                    .values(etat_silence="archive")
                )
                result = self.session.execute(stmt)
                logger.info(f"Archivé {result.rowcount} silencieux non présents.")

            # 4) Préparer bulk upsert
            records = df.to_dict(orient="records")
            existing = {
                obj.prm: obj.id
                for obj in self.session.query(Silencieux.prm, Silencieux.id)
            }

            inserts = []
            updates = []

            for row in records:
                prm = row.get("prm")
                if not prm:
                    continue  # skip ligne mal formée

                common = {
                    "priorite":                  row.get("priorite_de_traitement") or "",
                    "cause_silence":             row.get("cause_silence"),
                    "probabilite_defaillance":   row.get("probabilite_de_defaillance"),
                    "presence_da_c":             row.get("presence_da_c"),
                    "presence_da_k":             row.get("presence_da_k"),
                    "presence_dit_c":            row.get("presence_dit_c"),
                    "presence_dit_k":            row.get("presence_dit_k"),
                    "dr":                        row.get("dr"),
                    "affaire_l001":              row.get("affaire_l001"),
                    "agence_intervention":       row.get("agence_d_intervention"),
                    "base_op":                   row.get("base_operationnelle"),
                    "code_insee":                row.get("code_insee"),
                    "compteur":                  row.get("compteur"),
                    "constructeur":              row.get("constructeur"),
                    "date_ouverture_da_c":       self._convert_date(row.get("date_d_ouverture_da_c")),
                    "date_derniere_collecte":    self._convert_date(row.get("date_derniere_collecte")),
                    "id_depart":                 row.get("id_depart"),
                    "accessibilite":             row.get("accessibilite"),
                    "cause_generale":            row.get("lb_cause_generale"),
                    "nb_ligne":                  int(row["nb_c_ligne"]) if row.get("nb_c_ligne") else None,
                    "nb_jour_non_collecte":      int(row["nb_jour_non_collecte"]) if row.get("nb_jour_non_collecte") else None,
                    "nb_jour_non_collecte_23h59":int(row["nb_jour_sans_collecte_23h59_c"]) if row.get("nb_jour_sans_collecte_23h59_c") else None,
                    "techno":                    row.get("palier___version_cpl"),
                    "pdk_com":                   row.get("pdk"),
                    "pdkc_egal_pdkr":            row.get("pdk_com___pdk_ref"),
                    "pdk_ref":                   row.get("pdk_ref"),
                    "priorite_pilprod":          int(row["priorite_pilprod"]) if row.get("priorite_pilprod") else None,
                    "regime":                    row.get("regime"),
                    "statut_contrat":            row.get("statut_contrat"),
                    "tranche":                   row.get("tranches_par_mois"),
                    "type_production":           row.get("type_ec"),
                    "date_entree_cause_silence": self._convert_date(row.get("date_entree_cause_silence")),
                    "champs_t":                  row.get("lb_coupure_plus_accessible"),
                }

                if prm in existing:
                    # UPDATE
                    updates.append({
                        "id":              existing[prm],
                        **common,
                        "etat_silence":    "en cours",
                        "date_import":     now
                    })
                else:
                    # INSERT
                    inserts.append({
                        "prm":             prm,
                        **common,
                        "etat_silence":    "nouveau",
                        "date_import":     now
                    })

            # 5) Bulk insert & update
            if inserts:
                self.session.bulk_insert_mappings(Silencieux, inserts)
            if updates:
                self.session.bulk_update_mappings(Silencieux, updates)

            self.session.commit()
            logger.info(f"{len(inserts)} inserts, {len(updates)} updates effectués.")
            return True

        except Exception:
            logger.exception("Erreur pendant l'upsert bulk Silencieux")
            self.session.rollback()
            return False
