import os
import sys
import logging

# 1) Bootstrapping du PYTHONPATH vers src/Command/python
PROJECT_DIR = os.environ.get("PROJECT_DIR", os.getcwd())
PY_SRC     = os.path.join(PROJECT_DIR, "src", "Command", "python")
if PY_SRC not in sys.path:
    sys.path.insert(0, PY_SRC)

from sqlalchemy.orm import sessionmaker
from database import engine
from loader.loader_capella import LoaderCapella

# 2) Configuration du logger
log_dir = os.path.join(PROJECT_DIR, "var", "log")
os.makedirs(log_dir, exist_ok=True)
logfile = os.path.join(log_dir, "capella_loader.log")

logger = logging.getLogger("capella_loader")
logger.setLevel(logging.INFO)
if not logger.handlers:
    fh = logging.FileHandler(logfile, encoding="utf-8")
    sh = logging.StreamHandler(sys.stdout)
    fmt = logging.Formatter("%(asctime)s [%(levelname)s] %(name)s: %(message)s")
    fh.setFormatter(fmt)
    sh.setFormatter(fmt)
    logger.addHandler(fh)
    logger.addHandler(sh)

# 3) Entrypoint
if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python import_capella.py <chemin_du_fichier.csv>")
        sys.exit(1)

    raw = sys.argv[1]
    path = os.path.normpath(raw)
    if not os.path.exists(path):
        logger.error(f"Fichier introuvable : {path}")
        sys.exit(1)

    SessionLocal = sessionmaker(bind=engine)
    session      = SessionLocal()

    loader = LoaderCapella(session)
    success = loader.load_csv(path)
    session.close()

    sys.exit(0 if success else 1)
