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
        logging.FileHandler('var/log/import_meteore_poste_dp.log')
    ]
)
logger = logging.getLogger(__name__)

def parse_args():
    parser = argparse.ArgumentParser(description='Import des données Météore Poste DP')
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
            INSERT INTO bridge_meteore_poste_dp (
                base_oper,
                code_gdo,
                nom,
                fctn_poste_sig_orig,
                fonction,
                detail_emplacement,
                commentaire,
                date_crea_sig,
                date_mise_en_exploitation,
                date_maj_sig,
                date_mise_hors_expl,
                dossier_sig_crea,
                dossier_sig_modif,
                statut,
                type,
                pos_geo_long_lat_wkt,
                created_at
            ) VALUES (
                %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW()
            )
        """

        rows_inserted = 0
        for index, row in df.iterrows():
            try:
                # Conversion des valeurs nan en None (NULL en SQL)
                values = (
                    None if pd.isna(row.get('BASE_OPER', None)) else row.get('BASE_OPER'),
                    None if pd.isna(row.get('CODE_GDO', None)) else row.get('CODE_GDO'),
                    None if pd.isna(row.get('NOM', None)) else row.get('NOM'),
                    None if pd.isna(row.get('FCTN_POSTE_SIG_ORIG', None)) else row.get('FCTN_POSTE_SIG_ORIG'),
                    None if pd.isna(row.get('FONCTION', None)) else row.get('FONCTION'),
                    None if pd.isna(row.get('DETAIL_EMPLACEMENT', None)) else row.get('DETAIL_EMPLACEMENT'),
                    None if pd.isna(row.get('COMMENTAIRE', None)) else row.get('COMMENTAIRE'),
                    pd.to_datetime(row.get('DATE_CREA_SIG', None)) if pd.notna(row.get('DATE_CREA_SIG')) else None,
                    pd.to_datetime(row.get('DATE_MISE_EN_EXPLOITATION', None)) if pd.notna(row.get('DATE_MISE_EN_EXPLOITATION')) else None,
                    pd.to_datetime(row.get('DATE_MAJ_SIG', None)) if pd.notna(row.get('DATE_MAJ_SIG')) else None,
                    pd.to_datetime(row.get('DATE_MISE_HORS_EXPL', None)) if pd.notna(row.get('DATE_MISE_HORS_EXPL')) else None,
                    None if pd.isna(row.get('DOSSIER_SIG_CREA', None)) else row.get('DOSSIER_SIG_CREA'),
                    None if pd.isna(row.get('DOSSIER_SIG_MODIF', None)) else row.get('DOSSIER_SIG_MODIF'),
                    None if pd.isna(row.get('STATUT', None)) else row.get('STATUT'),
                    None if pd.isna(row.get('TYPE', None)) else row.get('TYPE'),
                    None if pd.isna(row.get('POS_GEO_LONG_LAT_WKT', None)) else row.get('POS_GEO_LONG_LAT_WKT')
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