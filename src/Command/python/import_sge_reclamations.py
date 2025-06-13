#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import sys
import os
import pandas as pd
import mysql.connector
from datetime import datetime
import argparse
import logging
import zipfile
import tempfile
import shutil

# Configuration du logging
logging.basicConfig(
    level=logging.DEBUG,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.StreamHandler(sys.stdout),
        logging.FileHandler('var/log/import_sge_reclamations.log')
    ]
)
logger = logging.getLogger(__name__)

def parse_args():
    parser = argparse.ArgumentParser(description='Import des données SGE Réclamations')
    parser.add_argument('file', help='Chemin du fichier à importer (CSV ou ZIP)')
    parser.add_argument('--limit', type=int, help='Nombre maximal de lignes à traiter')
    parser.add_argument('--offset', type=int, help='Nombre de lignes à sauter')
    args = parser.parse_args()
    logger.debug(f"Arguments reçus: {args}")
    return args

def connect_to_db():
    try:
        db_config = {
            'host': os.getenv('DB_HOST', 'localhost'),
            'user': os.getenv('DB_USER', 'root'),
            'password': os.getenv('DB_PASSWORD', ''),
            'database': os.getenv('DB_NAME', 'parc-cpa')
        }
        logger.debug(f"Tentative de connexion à la base de données avec la config: {db_config}")
        
        conn = mysql.connector.connect(**db_config)
        logger.info("Connexion à la base de données réussie")
        return conn
    except Exception as e:
        logger.error(f"Erreur de connexion à la base de données: {str(e)}")
        raise

def extract_zip(zip_path):
    temp_dir = tempfile.mkdtemp()
    logger.debug(f"Création du dossier temporaire: {temp_dir}")
    
    try:
        with zipfile.ZipFile(zip_path, 'r') as zip_ref:
            file_list = zip_ref.namelist()
            logger.info(f"Fichiers trouvés dans le ZIP: {', '.join(file_list)}")
            zip_ref.extractall(temp_dir)
            logger.info(f"Fichiers extraits dans: {temp_dir}")
            extracted_files = os.listdir(temp_dir)
            logger.debug(f"Contenu du dossier temporaire: {extracted_files}")
            return temp_dir
    except Exception as e:
        logger.error(f"Erreur lors de l'extraction du ZIP: {str(e)}")
        if os.path.exists(temp_dir):
            shutil.rmtree(temp_dir)
        raise

def process_file(file_path, limit=None, offset=None):
    temp_dir = None
    try:
        logger.info(f"Tentative de lecture du fichier: {file_path}")
        
        if not os.path.exists(file_path):
            logger.error(f"Le fichier n'existe pas: {file_path}")
            return

        if file_path.lower().endswith('.zip'):
            logger.info("Fichier ZIP détecté, extraction en cours...")
            temp_dir = extract_zip(file_path)
            csv_files = [f for f in os.listdir(temp_dir) if f.lower().endswith('.csv')]
            if not csv_files:
                raise Exception("Aucun fichier CSV trouvé dans le ZIP")
            file_path = os.path.join(temp_dir, csv_files[0])

        df = pd.read_csv(file_path, sep=';', encoding='utf-8')
        logger.info(f"Fichier lu avec succès. {len(df)} lignes trouvées")
        logger.debug(f"Colonnes trouvées: {', '.join(df.columns)}")
        
        # Conversion de POINT_ID_RECLAMATION en string et suppression des .0
        if 'POINT_ID_RECLAMATION' in df.columns:
            df['POINT_ID_RECLAMATION'] = df['POINT_ID_RECLAMATION'].fillna('').astype(str).str.replace('.0', '')
        
        if offset:
            df = df.iloc[offset:]
        if limit:
            df = df.iloc[:limit]

        conn = connect_to_db()
        cursor = conn.cursor()

        # Vérification et modification de la structure de la table si nécessaire
        cursor.execute("SHOW COLUMNS FROM sge_reclamations LIKE 'point_id_reclamation'")
        column_info = cursor.fetchone()
        if column_info:
            if 'varchar' not in column_info[1].lower():
                logger.info("Modification de la colonne point_id_reclamation en VARCHAR(20)")
                cursor.execute("ALTER TABLE sge_reclamations MODIFY COLUMN point_id_reclamation VARCHAR(20)")
                conn.commit()

        insert_query = """
            INSERT INTO sge_reclamations (
                libelle_statut,
                code_statut,
                segment,
                description_demande_precision,
                date_reception_reclamation,
                libelle_objet_demande,
                denomination_sociale_personnemorale,
                nom_commercial_personnemorale,
                nom_personnephysique,
                prenom_personnephysique,
                telephone1num_reclamant,
                telephone2num_reclamant,
                adresse_email_reclamant,
                libelle_type,
                nom_interlocuteur,
                prenom_interlocuteur,
                libelle_reclamation,
                point_id_reclamation,
                batiment_adresse,
                numero_nom_voie_adresse,
                lieu_dit_adresse,
                code_postal_adresse,
                libelle_commune,
                libelle_site,
                code_insee_reclamation,
                libelle_motif_demande,
                description_reclamation,
                reponse_directe_reclamant_reclamation,
                saisine_mediateur_reclamation,
                prejudice_client_reclamation,
                libelle_nature_prejudice,
                commentaire_sensibilite,
                code_processus,
                numero_reclamation,
                categorie,
                libelle_type_demande,
                libelle_sous_type,
                nature_demande_libelle,
                recevabilite_etat_affaire,
                prm_usage,
                application_source,
                acteurtraitement,
                id_traitement,
                trig_dr,
                created_at
            ) VALUES (
                %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
                %s, %s, %s, %s, NOW()
            )
        """

        rows_inserted = 0
        for index, row in df.iterrows():
            try:
                values = (
                    None if pd.isna(row.get('LIBELLE_STATUT', None)) else row.get('LIBELLE_STATUT'),
                    None if pd.isna(row.get('CODE_STATUT', None)) else row.get('CODE_STATUT'),
                    None if pd.isna(row.get('SEGMENT', None)) else row.get('SEGMENT'),
                    None if pd.isna(row.get('DESCRIPTION_DEMANDE_PRECISION', None)) else row.get('DESCRIPTION_DEMANDE_PRECISION'),
                    pd.to_datetime(row.get('DATE_RECEPTION_RECLAMATION', None)) if pd.notna(row.get('DATE_RECEPTION_RECLAMATION')) else None,
                    None if pd.isna(row.get('LIBELLE_OBJET_DEMANDE', None)) else row.get('LIBELLE_OBJET_DEMANDE'),
                    None if pd.isna(row.get('DENOMINATION_SOCIALE_PERSONNEMORALE', None)) else row.get('DENOMINATION_SOCIALE_PERSONNEMORALE'),
                    None if pd.isna(row.get('NOM_COMMERCIAL_PERSONNEMORALE', None)) else row.get('NOM_COMMERCIAL_PERSONNEMORALE'),
                    None if pd.isna(row.get('NOM_PERSONNEPHYSIQUE', None)) else row.get('NOM_PERSONNEPHYSIQUE'),
                    None if pd.isna(row.get('PRENOM_PERSONNEPHYSIQUE', None)) else row.get('PRENOM_PERSONNEPHYSIQUE'),
                    None if pd.isna(row.get('TELEPHONE1NUM_RECLAMANT', None)) else row.get('TELEPHONE1NUM_RECLAMANT'),
                    None if pd.isna(row.get('TELEPHONE2NUM_RECLAMANT', None)) else row.get('TELEPHONE2NUM_RECLAMANT'),
                    None if pd.isna(row.get('ADRESSE_EMAIL_RECLAMANT', None)) else row.get('ADRESSE_EMAIL_RECLAMANT'),
                    None if pd.isna(row.get('LIBELLE_TYPE', None)) else row.get('LIBELLE_TYPE'),
                    None if pd.isna(row.get('NOM_INTERLOCUTEUR', None)) else row.get('NOM_INTERLOCUTEUR'),
                    None if pd.isna(row.get('PRENOM_INTERLOCUTEUR', None)) else row.get('PRENOM_INTERLOCUTEUR'),
                    None if pd.isna(row.get('LIBELLE_RECLAMATION', None)) else row.get('LIBELLE_RECLAMATION'),
                    None if pd.isna(row.get('POINT_ID_RECLAMATION', None)) else row.get('POINT_ID_RECLAMATION'),
                    None if pd.isna(row.get('BATIMENT_ADRESSE', None)) else row.get('BATIMENT_ADRESSE'),
                    None if pd.isna(row.get('NUMERO_NOM_VOIE_ADRESSE', None)) else row.get('NUMERO_NOM_VOIE_ADRESSE'),
                    None if pd.isna(row.get('LIEU_DIT_ADRESSE', None)) else row.get('LIEU_DIT_ADRESSE'),
                    None if pd.isna(row.get('CODE_POSTAL_ADRESSE', None)) else row.get('CODE_POSTAL_ADRESSE'),
                    None if pd.isna(row.get('LIBELLE_COMMUNE', None)) else row.get('LIBELLE_COMMUNE'),
                    None if pd.isna(row.get('LIBELLE_SITE', None)) else row.get('LIBELLE_SITE'),
                    None if pd.isna(row.get('CODE_INSEE_RECLAMATION', None)) else row.get('CODE_INSEE_RECLAMATION'),
                    None if pd.isna(row.get('LIBELLE_MOTIF_DEMANDE', None)) else row.get('LIBELLE_MOTIF_DEMANDE'),
                    None if pd.isna(row.get('DESCRIPTION_RECLAMATION', None)) else row.get('DESCRIPTION_RECLAMATION'),
                    None if pd.isna(row.get('REPONSE_DIRECTE_RECLAMANT_RECLAMATION', None)) else row.get('REPONSE_DIRECTE_RECLAMANT_RECLAMATION'),
                    None if pd.isna(row.get('SAISINE_MEDIATEUR_RECLAMATION', None)) else row.get('SAISINE_MEDIATEUR_RECLAMATION'),
                    None if pd.isna(row.get('PREJUDICE_CLIENT_RECLAMATION', None)) else row.get('PREJUDICE_CLIENT_RECLAMATION'),
                    None if pd.isna(row.get('LIBELLE_NATURE_PREJUDICE', None)) else row.get('LIBELLE_NATURE_PREJUDICE'),
                    None if pd.isna(row.get('COMMENTAIRE_SENSIBILITE', None)) else row.get('COMMENTAIRE_SENSIBILITE'),
                    None if pd.isna(row.get('CODE_PROCESSUS', None)) else row.get('CODE_PROCESSUS'),
                    None if pd.isna(row.get('NUMERO_RECLAMATION', None)) else row.get('NUMERO_RECLAMATION'),
                    None if pd.isna(row.get('CATEGORIE', None)) else row.get('CATEGORIE'),
                    None if pd.isna(row.get('LIBELLE_TYPE_DEMANDE', None)) else row.get('LIBELLE_TYPE_DEMANDE'),
                    None if pd.isna(row.get('LIBELLE_SOUS_TYPE', None)) else row.get('LIBELLE_SOUS_TYPE'),
                    None if pd.isna(row.get('NATURE_DEMANDE_LIBELLE', None)) else row.get('NATURE_DEMANDE_LIBELLE'),
                    None if pd.isna(row.get('RECEVABILITE_ETAT_AFFAIRE', None)) else row.get('RECEVABILITE_ETAT_AFFAIRE'),
                    None if pd.isna(row.get('PRM_USAGE', None)) else row.get('PRM_USAGE'),
                    None if pd.isna(row.get('APPLICATION_SOURCE', None)) else row.get('APPLICATION_SOURCE'),
                    None if pd.isna(row.get('ACTEURTRAITEMENT', None)) else row.get('ACTEURTRAITEMENT'),
                    None if pd.isna(row.get('ID_TRAITEMENT', None)) else row.get('ID_TRAITEMENT'),
                    None if pd.isna(row.get('TRIG_DR', None)) else row.get('TRIG_DR')
                )
                cursor.execute(insert_query, values)
                rows_inserted += 1
                if rows_inserted % 100 == 0:
                    logger.info(f"{rows_inserted} lignes insérées...")
            except Exception as e:
                logger.error(f"Erreur lors de l'insertion de la ligne {index}: {row.to_dict()}")
                logger.error(f"Erreur: {str(e)}")
                continue

        conn.commit()
        logger.info(f"Import terminé avec succès. {rows_inserted} lignes insérées sur {len(df)} lignes traitées.")

    except Exception as e:
        logger.error(f"Erreur lors du traitement du fichier: {str(e)}")
        raise
    finally:
        if 'cursor' in locals():
            cursor.close()
        if 'conn' in locals():
            conn.close()
        if temp_dir and os.path.exists(temp_dir):
            shutil.rmtree(temp_dir)

def main():
    args = parse_args()
    
    if not os.path.exists(args.file):
        logger.error(f"Le fichier {args.file} n'existe pas")
        sys.exit(1)

    try:
        process_file(args.file, args.limit, args.offset)
    except Exception as e:
        logger.error(f"Erreur lors de l'import: {str(e)}")
        sys.exit(1)

if __name__ == '__main__':
    main() 