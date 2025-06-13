#!/usr/bin/env python3
# src/Command/python/import_bridge_ginko_taches.py

import os
import sys
import logging

# --- Bootstrapping PYTHONPATH ---
PROJECT_DIR = os.environ.get('PROJECT_DIR', os.getcwd())
PY_SRC     = os.path.join(PROJECT_DIR, 'src', 'Command', 'python')
if PY_SRC not in sys.path:
    sys.path.insert(0, PY_SRC)

from sqlalchemy.orm import sessionmaker
from database import engine
from loader.loader_taches import LoaderBridgeGinkoTaches

# --- Logger Setup ---
log_dir = os.path.join(PROJECT_DIR, 'var', 'log')
if not os.path.isdir(log_dir):
    os.makedirs(log_dir, exist_ok=True)
logfile = os.path.join(log_dir, 'bridge_ginko_taches_loader.log')
logger = logging.getLogger('bridge_ginko_taches_loader')
logger.setLevel(logging.INFO)
if not logger.handlers:
    fh = logging.FileHandler(logfile, encoding='utf-8')
    sh = logging.StreamHandler(sys.stdout)
    fmt = logging.Formatter('%(asctime)s [%(levelname)s] %(name)s: %(message)s')
    fh.setFormatter(fmt)
    sh.setFormatter(fmt)
    logger.addHandler(fh)
    logger.addHandler(sh)

# --- Entrypoint ---
if __name__ == '__main__':
    if len(sys.argv) != 2:
        print('Usage: import_bridge_ginko_taches.py <chemin_csv>')
        sys.exit(1)

    csv_path = os.path.normpath(sys.argv[1])
    if not os.path.exists(csv_path):
        logger.error(f'Fichier introuvable : {csv_path}')
        sys.exit(1)

    # Création de la session SQLAlchemy
    SessionLocal = sessionmaker(bind=engine)
    session      = SessionLocal()

    # Lancement du loader
    loader = LoaderBridgeGinkoTaches(session)
    success = loader.load_csv(csv_path)
    session.close()
    sys.exit(0 if success else 1)
