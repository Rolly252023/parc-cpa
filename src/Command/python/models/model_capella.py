from sqlalchemy import Column, Integer, String, Date, Text, DateTime
from sqlalchemy.ext.declarative import declarative_base

Base = declarative_base()


class Capella(Base):
    __tablename__ = "capella"


    id = Column(Integer, primary_key=True)
    dossier = Column(String(50), nullable=False, unique=True)
    statut = Column(String(255), nullable=True)
    date_creation = Column(Date, nullable=True)
    titre = Column(String(255), nullable=True)
    createur = Column(String(255), nullable=True)
    entity_suivi = Column(String(255), nullable=True)
    bureau_suivi = Column(String(255), nullable=True)
    date_cloture = Column(Date, nullable=True)
    canal_echange = Column(String(255), nullable=True)
    sens_canal = Column(String(255), nullable=True)
    identifiant = Column(String(255), nullable=True)
    segment = Column(String(255), nullable=True)
    client = Column(String(255), nullable=True)
    code_insee = Column(String(5), nullable=True)
    processus = Column(String(255), nullable=True)
    type = Column(String(255), nullable=True)
    sous_type = Column(String(255), nullable=True)
    nni_cloture = Column(String(255), nullable=True)
    nom_cloture = Column(String(255), nullable=True)
    bureau_traitement = Column(String(255), nullable=True)
    created_at = Column(DateTime, nullable=True)
