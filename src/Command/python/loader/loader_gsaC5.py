import pandas as pd
import zipfile
import tempfile
from pathlib import Path
from datetime import datetime
import logging

from sqlalchemy.orm import Session
from sqlalchemy import text
from models.models_ginko_pds import BridgeGinkoPDS

logger = logging.getLogger(__name__)


class LoadBridgeGinkoPDS:
    TABLE_NAME = "bridge_ginko_pds"
    CHUNK_SIZE = 1000

    def __init__(self, session: Session):
        self.session = session

    def run(self, file_path: str, offset: int = 0, max_rows: int | None = None) -> bool:
        """
        Point d’entrée unique pour lancer l’import.
        """
        try:
            path = Path(file_path)
            if path.suffix.lower() == ".zip":
                path = self._extract_first_csv_from_zip(path)

            self._truncate()

            logger.info(f"Début de l'import du fichier {path.name}")
            self._import_csv(path, offset=offset, max_rows=max_rows)

            logger.info("✅ Import terminé avec succès.")
            return True

        except Exception as e:
            logger.exception(f"❌ Erreur pendant l'import : {e}")
            return False

    def _truncate(self):
        logger.info(f"Vidage de la table `{self.TABLE_NAME}`...")
        self.session.execute(text("SET FOREIGN_KEY_CHECKS = 0"))
        self.session.execute(text(f"TRUNCATE TABLE {self.TABLE_NAME}"))
        self.session.execute(text("SET FOREIGN_KEY_CHECKS = 1"))
        self.session.commit()

    def _extract_first_csv_from_zip(self, zip_path: Path) -> Path:
        logger.info(f"Extraction de l’archive : {zip_path}")
        with zipfile.ZipFile(zip_path, "r") as zip_ref:
            temp_dir = Path(tempfile.mkdtemp(prefix="ginko_pds_"))
            zip_ref.extractall(temp_dir)
            csv_files = list(temp_dir.glob("*.csv"))
            if not csv_files:
                raise FileNotFoundError("Aucun fichier CSV trouvé dans le ZIP.")
            logger.info(f"Fichier CSV extrait : {csv_files[0]}")
            return csv_files[0]

    def _import_csv(self, csv_path: Path, offset: int, max_rows: int | None):
        total_inserted = 0
        skipped_rows = 0

        for chunk in pd.read_csv(csv_path, sep=";", dtype=str, chunksize=self.CHUNK_SIZE):
            chunk.fillna("", inplace=True)

            # Gestion du offset
            if offset > 0 and skipped_rows + len(chunk) <= offset:
                skipped_rows += len(chunk)
                continue
            elif offset > 0:
                chunk = chunk[offset - skipped_rows:]
                offset = 0  # offset traité
                skipped_rows = 0

            # Gestion de la limite max_rows
            if max_rows is not None and total_inserted + len(chunk) > max_rows:
                chunk = chunk[: max_rows - total_inserted]

            objects = [self._map_row(row) for _, row in chunk.iterrows()]
            self.session.add_all(objects)
            self.session.commit()

            total_inserted += len(objects)
            logger.info(f"{total_inserted} lignes insérées...")

            if max_rows is not None and total_inserted >= max_rows:
                logger.info(f"Limite max atteinte ({max_rows} lignes), arrêt.")
                break

    def _convert_date(self, value: str, in_fmt="%Y-%m-%d %H:%M:%S", out_fmt="%Y-%m-%d"):
        try:
            return datetime.strptime(value, in_fmt).strftime(out_fmt) if value.strip() else None
        except Exception:
            return None

    def _map_row(self, row) -> BridgeGinkoPDS:
        return BridgeGinkoPDS(
            id_pds=int(row["ID"]),
            id_pds_ginko=row["ID_PDS_GINKO"],
            reference=row["REFERENCE"],
            edl_id=int(row["EDL_ID"]),
            edl_reference=row["EDL_REFERENCE"],
            edl_typespace=row["EDL_TYPEESPACE"],
            etat=row["ETAT"],
            sousetat=row["SOUSETAT"],
            coupe=row["COUPE"],
            motif_coupure=row["MOTIFCOUPURE"],
            coupure_accessible=row["COUPUREACCESSIBLE"],
            nature=row["NATURE"],
            typeinjection=row["TYPEINJECTION"],
            limitation=row["LIMITATION"],
            puissancelimitation=row["PUISSANCELIMITATION"],
            lieulimitation=row["LIEULIMITATION"],
            motiflimitation=row["MOTIFLIMITATION"],
            puissancelimitetechnique=row["PUISSANCELIMITETECHNIQUE"],
            communicabilite=row["COMMUNICABILITE"],
            normecommunicationcpl=row["NORMECOMMUNICATIONCPL"],
            ccpiaccessible=row["CCPIACCESSIBLE"],
            emplacementcompteur=row["EMPLACEMENTCOMPTEUR"],
            accescompteur=row["ACCESCOMPTEUR"],
            accesdisjoncteur=row["ACCESDISJONCTEUR"],
            modereleve=row["MODERELEVE"],
            typetension=row["TYPETENSION"],
            ahautrisquevital=row["AHAUTRISQUEVITAL"],
            teleoperable=row["TELEOPERABLE"],
            dateteleoperable=self._convert_date(row["DATETELEOPERABLE"]),
            datebasculecommactive=self._convert_date(row["DATEBASCULECOMMACTIVE"]),
            datecreation=self._convert_date(row["DATECREATION"]),
            releveagent_date=self._convert_date(row["RELEVEAGENT_DATE"]),
            datemodification=self._convert_date(row["DATEMODIFICATION"], "%Y-%m-%d %H:%M:%S", "%Y-%m-%d %H:%M:%S"),
            dateetat=self._convert_date(row["DATEETAT"]),
            dateetatlimitation=self._convert_date(row["DATEETATLIMITATION"]),
            datemodifniveaucomm=self._convert_date(row["DATEMODIFNIVEAUCOMM"]),
            datemiseenservice=self._convert_date(row["DATEMISEENSERVICE"]),
            commentaireintervenant=row["COMMENTAIREINTERVENANT"],
            niveauouvertureservice=row["NIVEAUOUVERTURESERVICE"],
            utilisation=row["UTILISATION"],
            centre_code=row["CENTRE_CODE"],
            positiongps_lat=row["POSITIONGPS_LAT"],
            positiongps_lgt=row["POSITIONGPS_LGT"],
            adresse=row["ADRESSE"],
            adresse_compl=row["ADRESSE_COMPL"],
            codepostal=row["CODEPOSTAL"],
            commune=row["COMMUNE"],
            codeinsee=row["CODEINSEE"],
            created_at=datetime.utcnow(),
        )
