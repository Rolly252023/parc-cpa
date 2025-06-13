# src/Command/python/services/loader_ginko_taches.py

from pathlib import Path
from datetime import datetime
import logging
import unicodedata
import pandas as pd
from sqlalchemy.orm import Session
from sqlalchemy import text

from models.model_taches import BridgeGinkoTaches

logger = logging.getLogger("bridge_ginko_taches_loader")


class LoaderBridgeGinkoTaches:
    TABLE_NAME = "bridge_ginko_taches"

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

    def _convert_datetime(self, val: str):
        if not val or pd.isna(val) or not val.strip():
            return None
        for fmt in ("%Y-%m-%d %H:%M:%S", "%d/%m/%Y %H:%M:%S"):
            try:
                return datetime.strptime(val.strip(), fmt)
            except ValueError:
                continue
        return None

    def load_csv(self, file_path: str) -> bool:
        try:
            logger.info(f"Chargement du CSV : {file_path}")
            df = pd.read_csv(
                file_path,
                sep=";",
                dtype=str,
                encoding="utf-8-sig",  # gestion du BOM + accents
                skipinitialspace=True,
                engine="python",
            )

            df.columns = [self._slugify(c) for c in df.columns]
            logger.info(f"Colonnes normalisées : {list(df.columns)}")
            df.fillna("", inplace=True)
            records = df.to_dict(orient="records")
            logger.info(f"{len(records)} lignes à traiter")

            existing = {
                obj.reference_tache: obj.id
                for obj in self.session.query(
                    BridgeGinkoTaches.reference_tache, BridgeGinkoTaches.id
                )
            }
            logger.info(f"{len(existing)} tâches existantes en base")

            inserts = []
            updates = []
            now = datetime.now()

            for idx, row in enumerate(records, start=1):
                raw = (row.get("reference_tache") or "").strip()
                if not raw.isdigit():
                    logger.warning(
                        f"Ligne {idx} ignorée : reference_tache invalide ({raw!r})"
                    )
                    continue

                ref_tache = int(raw)
                common = {
                    "reference_pds": row.get("reference_pds"),
                    "date_creation_tache": self._convert_datetime(
                        row.get("date_creation_tache")
                    ),
                    "extrait_tache": row.get("extrait_tache"),
                    "statut_tache": row.get("statut_tache"),
                    "date_debut_tache": self._convert_datetime(
                        row.get("date_debut_tache")
                    ),
                    "liste_gestion": row.get("liste_gestion"),
                    "famille_tache": row.get("famille_tache"),
                    "groupe_travail": row.get("groupe_travail"),
                    "libelle_nature_tache": row.get("libelle_nature_tache"),
                    "description_nature_tache": row.get("description_nature_tache"),
                    "commune": row.get("commune"),
                    "code_insee": (row.get("code_insee") or "").strip()[:5],
                    "code_centre": row.get("code_centre"),
                    "code_affaire": row.get("code_affaire"),
                    "reference_affaire": row.get("reference_affaire"),
                    "nature_intervention": row.get("nature_intervention"),
                    "objet_affaire": row.get("objet_affaire"),
                    "reference_sge": row.get("reference_sge"),
                }

                if ref_tache in existing:
                    updates.append(
                        {"id": existing[ref_tache], **common, "created_at": now}
                    )
                else:
                    inserts.append(
                    {"reference_tache": ref_tache, **common, "created_at": now}
                )

            logger.info(f"Préparation: {len(inserts)} inserts, {len(updates)} updates")

            if inserts:
                self.session.bulk_insert_mappings(BridgeGinkoTaches, inserts)
                logger.info(f"Inserted {len(inserts)} tâches")
            if updates:
                self.session.bulk_update_mappings(BridgeGinkoTaches, updates)
                logger.info(f"Updated {len(updates)} tâches")

            self.session.commit()
            logger.info("Import BridgeGinkoTaches terminé")
            return True

        except Exception as e:
            logger.exception(f"Erreur import BridgeGinkoTaches: {e}")
            self.session.rollback()
            return False
