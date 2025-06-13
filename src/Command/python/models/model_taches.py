from sqlalchemy import Column, Integer, String, Float, Date, DateTime, Text
from sqlalchemy.ext.declarative import declarative_base

Base = declarative_base()


class BridgeGinkoTaches(Base):
    __tablename__ = "bridge_ginko_taches"

    id = Column(Integer, primary_key=True)
    reference_tache = Column(Integer, nullable=False, unique=True)
    reference_pds = Column(String(15), nullable=False)
    date_creation_tache = Column(DateTime, nullable=False)
    extrait_tache = Column(String(255), nullable=True)
    statut_tache = Column(String(255), nullable=True)
    date_debut_tache = Column(DateTime, nullable=True)
    liste_gestion = Column(String(255), nullable=True)
    famille_tache = Column(String(255), nullable=True)
    groupe_travail = Column(String(255), nullable=True)
    libelle_nature_tache = Column(String(255), nullable=True)
    description_nature_tache = Column(String(255), nullable=True)
    commune = Column(String(255), nullable=True)
    code_insee = Column(String(5), nullable=True)
    code_centre = Column(String(3), nullable=True)
    code_affaire = Column(String(255), nullable=True)
    reference_affaire = Column(String(255), nullable=True)
    nature_intervention = Column(String(255), nullable=True)
    objet_affaire = Column(String(255), nullable=True)
    reference_sge = Column(String(255), nullable=True)
    created_at = Column(DateTime, nullable=False)
