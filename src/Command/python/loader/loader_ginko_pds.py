# src/Command/python/services/loader_ginko_pds.py

import zipfile
import tempfile
from pathlib import Path
from datetime import datetime
import logging

import pandas as pd
from sqlalchemy.orm import Session
from sqlalchemy import text

from models.models_ginko_pds import BridgeGinkoPDS

logger = logging.getLogger("ginko_pds_loader")


class LoadBridgeGinkoPDS:
    """Import bulk optimisé pour BridgeGinkoPDS via mappings SQLAlchemy."""
    TABLE_NAME = "bridge_ginko_pds"

    def __init__(self, session: Session):
        self.session = session

    def run(self, file_path: str, offset: int = 0, max_rows: int | None = None) -> bool:
        try:
            logger.info("=== [GINKO PDS IMPORT STARTED] ===")
            logger.info(f"Fichier : {file_path} | offset={offset}, limit={max_rows}")

            path = Path(file_path)
            if path.suffix.lower() == ".zip":
                path = self._extract_first_csv_from_zip(path)

            # on vide la table
            self._truncate()

            # on réalise l'upsert bulk
            inserted, updated = self._upsert_bulk(path, offset, max_rows)

            if inserted + updated == 0:
                logger.warning("⚠️ Aucun enregistrement importé.")
                return False

            logger.info(f"✅ {inserted} inserts, {updated} updates réalisés.")
            logger.info("=== [GINKO PDS IMPORT FINISHED] ===")
            return True

        except Exception:
            logger.exception("❌ Erreur critique durant l'import GinkoPDS")
            return False

    def _truncate(self) -> None:
        logger.info(f"Truncate table `{self.TABLE_NAME}`")
        self.session.execute(text("SET FOREIGN_KEY_CHECKS = 0"))
        self.session.execute(text(f"TRUNCATE TABLE {self.TABLE_NAME}"))
        self.session.execute(text("SET FOREIGN_KEY_CHECKS = 1"))
        self.session.commit()
        logger.info("Table vidée.")

    def _extract_first_csv_from_zip(self, zip_path: Path) -> Path:
        logger.info(f"Extraction ZIP : {zip_path}")
        with zipfile.ZipFile(zip_path, "r") as zip_ref:
            tmpdir = Path(tempfile.mkdtemp(prefix="ginko_pds_"))
            zip_ref.extractall(tmpdir)
            csvs = list(tmpdir.glob("*.csv"))
            if not csvs:
                raise FileNotFoundError("Aucun CSV dans l'archive.")
            return csvs[0]

    def _upsert_bulk(
        self,
        csv_path: Path,
        offset: int,
        max_rows: int | None
    ) -> tuple[int, int]:
        # Lecture du CSV complet
        df = pd.read_csv(
            csv_path,
            sep=";",
            dtype=str,
            encoding="cp1252",
            skipinitialspace=True,
            engine="python"
        )

        # Appliquer offset et limit
        if offset > 0:
            df = df.iloc[offset:]
        if max_rows is not None:
            df = df.iloc[:max_rows]

        logger.info(f"CSV chargé: {len(df)} lignes après slicing.")

        df.fillna("", inplace=True)
        records = df.to_dict(orient="records")

        # Récupérer les clés existantes (id_pds) en base
        existing = {
            row.id_pds: row.id
            for row in self.session.query(BridgeGinkoPDS.id, BridgeGinkoPDS.id_pds)
        }

        inserts = []
        updates = []
        now = datetime.utcnow()

        for row in records:
            try:
                pds_id = int(row["ID"])
            except (KeyError, ValueError):
                logger.warning("Ligne sans ID valide, sautée.")
                continue

            # mapping commun
            common = {
                "id_pds_ginko":           row.get("ID_PDS_GINKO"),
                "reference":              row.get("REFERENCE"),
                "edl_id":                 int(row["EDL_ID"]) if row.get("EDL_ID") else None,
                "edl_reference":          row.get("EDL_REFERENCE"),
                "edl_typespace":          row.get("EDL_TYPEESPACE"),
                "etat":                   row.get("ETAT"),
                "sousetat":               row.get("SOUSETAT"),
                "coupe":                  row.get("COUPE"),
                "motif_coupure":          row.get("MOTIFCOUPURE"),
                "coupure_accessible":     row.get("COUPEACCESSIBLE"),
                "nature":                 row.get("NATURE"),
                "typeinjection":          row.get("TYPEINJECTION"),
                "limitation":             row.get("LIMITATION"),
                "puissancelimitation":    row.get("PUISSANCELIMITATION"),
                "lieulimitation":         row.get("LIEULIMITATION"),
                "motiflimitation":        row.get("MOTIFLIMITATION"),
                "puissancelimitetechnique": row.get("PUISSANCELIMITETECHNIQUE"),
                "communicabilite":        row.get("COMMUNICABILITE"),
                "normecommunicationcpl":  row.get("NORMECOMMUNICATIONCPL"),
                "ccpiaccessible":         row.get("CCPIACCESSIBLE"),
                "emplacementcompteur":    row.get("EMPLACEMENTCOMPTEUR"),
                "accescompteur":          row.get("ACCESCOMPTEUR"),
                "accesdisjoncteur":       row.get("ACCESDISJONCTEUR"),
                "modereleve":             row.get("MODERELEVE"),
                "typetension":            row.get("TYPETENSION"),
                "ahautrisquevital":       row.get("AHAUTRISQUEVITAL"),
                "teleoperable":           row.get("TELEOPERABLE"),
                "dateteleoperable":       self._convert_date(row.get("DATETELEOPERABLE")),
                "datebasculecommactive":  self._convert_date(row.get("DATEBASCULECOMMACTIVE")),
                "datecreation":           self._convert_date(row.get("DATECREATION")),
                "releveagent_date":       self._convert_date(row.get("RELEVEAGENT_DATE")),
                "datemodification":       self._convert_date(
                                              row.get("DATEMODIFICATION"),
                                              "%Y-%m-%d %H:%M:%S",
                                              "%Y-%m-%d"
                                          ),
                "dateetat":               self._convert_date(row.get("DATEETAT")),
                "dateetatlimitation":     self._convert_date(row.get("DATEETATLIMITATION")),
                "datemodifniveaucomm":    self._convert_date(row.get("DATEMODIFNIVEAUCOMM")),
                "datemiseenservice":      self._convert_date(row.get("DATEMISEENSERVICE")),
                "commentaireintervenant": row.get("COMMENTAIREINTERVENANT"),
                "niveauouvertureservice": row.get("NIVEAUOUVERTURESERVICE"),
                "utilisation":            row.get("UTILISATION"),
                "centre_code":            row.get("CENTRE_CODE"),
                "positiongps_lat":        row.get("POSITIONGPS_LAT"),
                "positiongps_lgt":        row.get("POSITIONGPS_LGT"),
                "adresse":                row.get("ADRESSE"),
                "adresse_compl":          row.get("ADRESSE_COMPL"),
                "codepostal":             row.get("CODEPOSTAL"),
                "commune":                row.get("COMMUNE"),
                "codeinsee":              row.get("CODEINSEE"),
            }

            if pds_id in existing:
                # update
                updates.append({
                    "id": existing[pds_id],
                    **common
                })
            else:
                # insert
                inserts.append({
                    "id_pds":      pds_id,
                    **common,
                    "created_at":  now
                })

        # Bulk operations
        inserted = updated = 0
        if inserts:
            self.session.bulk_insert_mappings(BridgeGinkoPDS, inserts)
            inserted = len(inserts)
        if updates:
            self.session.bulk_update_mappings(BridgeGinkoPDS, updates)
            updated = len(updates)

        self.session.commit()
        return inserted, updated

    def _convert_date(
        self,
        value: str,
        in_fmt: str = "%Y-%m-%d %H:%M:%S",
        out_fmt: str = "%Y-%m-%d"
    ):
        try:
            return datetime.strptime(value.strip(), in_fmt).strftime(out_fmt)
        except Exception:
            return None
