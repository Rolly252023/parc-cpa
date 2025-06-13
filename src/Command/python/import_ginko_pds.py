import argparse
import logging
from pathlib import Path
import sys
import os
import time
from datetime import datetime

# === Bootstrapping du PYTHONPATH ===
PROJECT_DIR = Path(os.environ.get("PROJECT_DIR", Path.cwd()))
PY_SRC = PROJECT_DIR / "src" / "Command" / "python"
sys.path.insert(0, str(PY_SRC))

from sqlalchemy.orm import sessionmaker
from database import engine
from loader.loader_ginko_pds import LoadBridgeGinkoPDS

# === Initialisation des logs ===
log_dir = PROJECT_DIR / "var" / "log"
log_dir.mkdir(parents=True, exist_ok=True)
log_file = log_dir / f"import_ginko.log"

logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s | %(levelname)s | %(name)s | %(message)s",
    handlers=[
        logging.FileHandler(log_file),
        logging.StreamHandler(sys.stdout)  # Affiche aussi dans le terminal
    ]
)
logger = logging.getLogger("import_ginko")


def run_import(filepath: str, limit: int = None, offset: int = 0) -> int:
    start = time.time()
    logger.info("┌──────────────────────────────────────────────┐")
    logger.info("│         Lancement de l'import Ginko          │")
    logger.info("└──────────────────────────────────────────────┘")
    logger.info(f"📄 Fichier : {filepath}")
    logger.info(f"📌 Offset  : {offset} | Limite : {limit}")

    try:
        Session = sessionmaker(bind=engine)
        with Session() as session:
            loader = LoadBridgeGinkoPDS(session)
            logger.info("▶️ Démarrage du loader...")
            success = loader.run(filepath, offset=offset, max_rows=limit)

        duration = round(time.time() - start, 2)
        if success:
            logger.info("✅ [OK] Import terminé avec succès.")
            logger.info(f"⏱ Temps total : {duration} secondes")
            return 0
        else:
            logger.error("❌ [KO] Import terminé sans succès.")
            return 1

    except Exception as e:
        logger.exception(f"💥 Erreur critique : {e}")
        return 1


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Import Ginko PDS depuis un CSV ou un ZIP.")
    parser.add_argument("filepath", help="Chemin vers le fichier CSV ou ZIP.")
    parser.add_argument("--limit", type=int, default=None, help="Limiter le nombre de lignes à importer.")
    parser.add_argument("--offset", type=int, default=0, help="Décalage de lignes à ignorer (offset).")
    args = parser.parse_args()

    exit_code = run_import(args.filepath, limit=args.limit, offset=args.offset)
    sys.exit(exit_code)
