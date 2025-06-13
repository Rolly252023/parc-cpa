import os
import sys
import logging

# === 1) Bootstrapping du PYTHONPATH ===
PROJECT_DIR = os.environ.get("PROJECT_DIR", os.getcwd())
PY_SRC     = os.path.join(PROJECT_DIR, "src", "Command", "python")
if PY_SRC not in sys.path:
    sys.path.insert(0, PY_SRC)
    
from sqlalchemy.orm import sessionmaker
from database import engine
from loader.loader_silencieux import LoaderSilencieux

# ==== Logger ====

PROJECT_DIR = os.environ.get("PROJECT_DIR", os.getcwd())
log_dir    = os.path.join(PROJECT_DIR, "var", "log")
os.makedirs(log_dir, exist_ok=True)

logfile = os.path.join(log_dir, "silencieux_loader.log")
logger  = logging.getLogger("silencieux_loader")
logger.setLevel(logging.INFO)

if not logger.handlers:
    fh = logging.FileHandler(logfile, encoding="utf-8")
    sh = logging.StreamHandler(sys.stdout)
    fmt = logging.Formatter("%(asctime)s [%(levelname)s] %(name)s: %(message)s")
    fh.setFormatter(fmt)
    sh.setFormatter(fmt)
    logger.addHandler(fh)
    logger.addHandler(sh)

# ==== Entrypoint ====

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python import_silencieux.py <chemin_du_fichier.csv>")
        sys.exit(1)

    raw_path = sys.argv[1]
    file_path = os.path.normpath(raw_path)
    if not os.path.exists(file_path):
        logger.error(f"Fichier introuvable: {file_path}")
        sys.exit(1)

    SessionLocal = sessionmaker(bind=engine)
    session      = SessionLocal()

    loader = LoaderSilencieux(session)
    success = loader.load_csv(file_path)
    session.close()

    sys.exit(0 if success else 1)
