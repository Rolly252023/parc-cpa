from sqlalchemy import Column, Integer, String, DateTime
from sqlalchemy.ext.declarative import declarative_base
from datetime import datetime

Base = declarative_base()

class GsaC5(Base):
    __tablename__ = 'gsa_c5'

    id = Column(Integer, primary_key=True, autoincrement=True)
    centre = Column(String(3), nullable=True)
    prm = Column(String(14), nullable=True)
    statut_client = Column(String(15), nullable=True)
    etat_rattachement = Column(String(20), nullable=True)
    nb_fils = Column(Integer, nullable=True)
    option_tarifaire = Column(String(255), nullable=True)
    branche_activite = Column(String(255), nullable=True)
    puissance_souscrite = Column(Integer, nullable=True)
    residence_secondaire = Column(String(3), nullable=True)
    nom_client = Column(String(255), nullable=True)
    num_rue = Column(String(10), nullable=True)
    nom_rue = Column(String(255), nullable=True)
    compl_adresse = Column(String(255), nullable=True)
    code_insee = Column(String(5), nullable=True)
    troncon_rattachement = Column(String(255), nullable=True)
    distance_rattachement = Column(String(255), nullable=True)
    position_x = Column(String(255), nullable=True)
    position_y = Column(String(255), nullable=True)
    gdo_ligne_bt = Column(String(255), nullable=True)
    gdo_poste = Column(String(255), nullable=True)
    nom_poste = Column(String(255), nullable=True)
    type_poste = Column(String(255), nullable=True)
    id_prm = Column(String(14), nullable=True)
    commune = Column(String(255), nullable=True)
    liaison_reseau_id = Column(String(255), nullable=True)
    updated_at = Column(DateTime, nullable=True)
    created_at = Column(DateTime, nullable=True)
