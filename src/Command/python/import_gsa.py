import os
import sys
import logging

# === 1) Bootstrapping du PYTHONPATH ===
PROJECT_DIR = os.environ.get("PROJECT_DIR", os.getcwd())
PY_SRC     = os.path.join(PROJECT_DIR, "src", "Command", "python")
if PY_SRC not in sys.path:
    sys.path.insert(0, PY_SRC)

# 1) récupération et normalisation du chemin du fichier
raw_path = sys.argv[1]
file_path = os.path.normpath(raw_path)
if not os.path.exists(file_path):
    raise FileNotFoundError(f"Le chemin spécifié est introuvable : {file_path}")

# 2) on récupère PROJECT_DIR passé par Symfony pour les imports / logs
PROJECT_DIR = os.environ.get('PROJECT_DIR', os.getcwd())
if PROJECT_DIR not in sys.path:
    sys.path.insert(0, PROJECT_DIR)

# 3) configuration du logger
logfile = os.path.join(PROJECT_DIR, 'var', 'log', 'gsa.log')
os.makedirs(os.path.dirname(logfile), exist_ok=True)
logger = logging.getLogger("gsa_logger")
logger.setLevel(logging.INFO)
fh = logging.FileHandler(logfile)
formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
fh.setFormatter(formatter)
logger.addHandler(fh)

logger.info(f"Début de l'import GSA sur {file_path}")

from sqlalchemy.orm import sessionmaker
from database import engine
from Command.python.loader.loader_gsaC5 import LoaderGsaC5

# 4) lancement du traitement
Session = sessionmaker(bind=engine)
session = Session()

try:
    loader = LoaderGsaC5(session)
    loader.load_csv(file_path)
    session.commit()
    logger.info("Import GSA terminé avec succès.")
except Exception:
    logger.exception("Erreur pendant l'import GSA")
    session.rollback()
    sys.exit(1)
finally:
    session.close()
