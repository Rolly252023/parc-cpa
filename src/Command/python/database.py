import os
import logging
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker

# Configuration du logger
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger("database")
print("==> database.py chargé depuis :", __file__)

# Lecture des variables d'environnement
DB_USER = os.getenv("DB_USER", "root")
DB_PASSWORD = os.getenv("DB_PASSWORD", "")
DB_HOST = os.getenv("DB_HOST", "localhost")
DB_NAME = os.getenv("DB_NAME", "parc-cpa")

# Log des valeurs chargées (masquer les infos sensibles dans la prod !)
logger.info(f"DB_USER: {DB_USER}")
logger.info(f"DB_HOST: {DB_HOST}")
logger.info(f"DB_NAME: {DB_NAME}")
logger.info(f"DB_PASSWORD is {'set' if DB_PASSWORD else 'not set'}")

# Vérification
if not all([DB_USER, DB_HOST, DB_NAME]):
    logger.error("Une ou plusieurs variables d'environnement sont manquantes ❌")
    raise EnvironmentError("Variables d'environnement manquantes.")

# Construction de l'URL de connexion
DATABASE_URL = f"mysql+pymysql://{DB_USER}:{DB_PASSWORD}@{DB_HOST}:3306/{DB_NAME}"
logger.info(f"Connecting to DB with: {DATABASE_URL}")

# Création de l'engine SQLAlchemy
engine = create_engine(DATABASE_URL, echo=False)

# Session factory
SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)
