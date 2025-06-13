from sqlalchemy import create_engine, text
from sqlalchemy.exc import SQLAlchemyError

DB_URL = "mysql+pymysql://root:@localhost/parc-cpa?charset=utf8mb4"

try:
    engine = create_engine(DB_URL)
    with engine.connect() as connection:
        result = connection.execute(text("SELECT 1"))
        print("Connexion OK ✅", result.fetchone())
except SQLAlchemyError as e:
    print("Erreur de connexion ❌ :", e)
