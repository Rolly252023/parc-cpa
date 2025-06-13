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
        logging.FileHandler('import_sge_prestations.log')
    ]
)
logger = logging.getLogger(__name__)

def parse_args():
    parser = argparse.ArgumentParser(description='Import des données SGE Prestations')
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
        
        if offset:
            df = df.iloc[offset:]
        if limit:
            df = df.iloc[:limit]

        conn = connect_to_db()
        cursor = conn.cursor()

        insert_query = """
            INSERT INTO sge_prestations (
                code_statut_affaire,
                libelle_statut_affaire,
                libelle_etat_affaire,
                segment,
                prm,
                rue_adresse,
                code_postal,
                commune,
                etat_point,
                date_heure_demande,
                code_type,
                libelle_type,
                code_option,
                libelle_option,
                nom_titulaire_contrat,
                prenom_titulaire_contrat,
                id_affaire,
                clientfinal_nom,
                clientfinal_prenom,
                created_at
            ) VALUES (
                %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW()
            )
        """

        rows_inserted = 0
        for index, row in df.iterrows():
            try:
                values = (
                    None if pd.isna(row.get('CODE_STATUT_AFFAIRE', None)) else row.get('CODE_STATUT_AFFAIRE'),
                    None if pd.isna(row.get('LIBELLE_STATUT_AFFAIRE', None)) else row.get('LIBELLE_STATUT_AFFAIRE'),
                    None if pd.isna(row.get('LIBELLE_ETAT_AFFAIRE', None)) else row.get('LIBELLE_ETAT_AFFAIRE'),
                    None if pd.isna(row.get('SEGMENT', None)) else row.get('SEGMENT'),
                    None if pd.isna(row.get('PRM', None)) else row.get('PRM'),
                    None if pd.isna(row.get('RUE_ADRESSE', None)) else row.get('RUE_ADRESSE'),
                    None if pd.isna(row.get('CODE_POSTAL', None)) else row.get('CODE_POSTAL'),
                    None if pd.isna(row.get('COMMUNE', None)) else row.get('COMMUNE'),
                    None if pd.isna(row.get('ETAT_POINT', None)) else row.get('ETAT_POINT'),
                    pd.to_datetime(row.get('DATE_HEURE_DEMANDE', None)) if pd.notna(row.get('DATE_HEURE_DEMANDE')) else None,
                    None if pd.isna(row.get('CODE_TYPE', None)) else row.get('CODE_TYPE'),
                    None if pd.isna(row.get('LIBELLE_TYPE', None)) else row.get('LIBELLE_TYPE'),
                    None if pd.isna(row.get('CODE_OPTION', None)) else row.get('CODE_OPTION'),
                    None if pd.isna(row.get('LIBELLE_OPTION', None)) else row.get('LIBELLE_OPTION'),
                    None if pd.isna(row.get('NOM_TITULAIRE_CONTRAT', None)) else row.get('NOM_TITULAIRE_CONTRAT'),
                    None if pd.isna(row.get('PRENOM_TITULAIRE_CONTRAT', None)) else row.get('PRENOM_TITULAIRE_CONTRAT'),
                    None if pd.isna(row.get('ID_AFFAIRE', None)) else row.get('ID_AFFAIRE'),
                    None if pd.isna(row.get('CLIENTFINAL_NOM', None)) else row.get('CLIENTFINAL_NOM'),
                    None if pd.isna(row.get('CLIENTFINAL_PRENOM', None)) else row.get('CLIENTFINAL_PRENOM')
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