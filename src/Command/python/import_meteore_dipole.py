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

# Configuration du logging avec plus de détails
logging.basicConfig(
    level=logging.DEBUG,  # Changé en DEBUG pour plus de détails
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.StreamHandler(sys.stdout),
        logging.FileHandler('import_meteore.log')  # Ajout d'un fichier de log
    ]
)
logger = logging.getLogger(__name__)

def parse_args():
    parser = argparse.ArgumentParser(description='Import des données Météore Dipole BR')
    parser.add_argument('file', help='Chemin du fichier à importer (CSV ou ZIP)')
    parser.add_argument('--limit', type=int, help='Nombre maximal de lignes à traiter')
    parser.add_argument('--offset', type=int, help='Nombre de lignes à sauter')
    args = parser.parse_args()
    logger.debug(f"Arguments reçus: {args}")
    return args

def connect_to_db():
    """Établit la connexion à la base de données"""
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
    """Extrait le contenu du fichier ZIP dans un dossier temporaire"""
    temp_dir = tempfile.mkdtemp()
    logger.debug(f"Création du dossier temporaire: {temp_dir}")
    
    try:
        with zipfile.ZipFile(zip_path, 'r') as zip_ref:
            # Liste tous les fichiers dans le ZIP
            file_list = zip_ref.namelist()
            logger.info(f"Fichiers trouvés dans le ZIP: {', '.join(file_list)}")
            
            # Extrait tous les fichiers
            zip_ref.extractall(temp_dir)
            logger.info(f"Fichiers extraits dans: {temp_dir}")
            
            # Vérifie le contenu du dossier temporaire
            extracted_files = os.listdir(temp_dir)
            logger.debug(f"Contenu du dossier temporaire: {extracted_files}")
            
            return temp_dir
    except Exception as e:
        logger.error(f"Erreur lors de l'extraction du ZIP: {str(e)}")
        if os.path.exists(temp_dir):
            shutil.rmtree(temp_dir)
        raise

def process_file(file_path, limit=None, offset=None):
    """Traite le fichier et importe les données"""
    temp_dir = None
    try:
        logger.info(f"Tentative de lecture du fichier: {file_path}")
        logger.debug(f"Type de fichier: {os.path.splitext(file_path)[1].lower()}")
        
        if not os.path.exists(file_path):
            logger.error(f"Le fichier n'existe pas: {file_path}")
            return

        # Vérifie si c'est un fichier ZIP
        if file_path.lower().endswith('.zip'):
            logger.info("Fichier ZIP détecté, extraction en cours...")
            temp_dir = extract_zip(file_path)
            # Cherche le premier fichier CSV dans le dossier temporaire
            csv_files = [f for f in os.listdir(temp_dir) if f.lower().endswith('.csv')]
            logger.debug(f"Fichiers CSV trouvés: {csv_files}")
            
            if not csv_files:
                raise Exception("Aucun fichier CSV trouvé dans le ZIP")
            file_path = os.path.join(temp_dir, csv_files[0])
            logger.info(f"Fichier CSV trouvé dans le ZIP: {file_path}")

        # Lecture du fichier
        logger.debug(f"Tentative de lecture du CSV: {file_path}")
        df = pd.read_csv(file_path, sep=';', encoding='utf-8')
        logger.info(f"Fichier lu avec succès. {len(df)} lignes trouvées")
        logger.debug(f"Colonnes trouvées: {', '.join(df.columns)}")
        logger.debug(f"Première ligne: {df.iloc[0].to_dict()}")
        
        # Application des limites si spécifiées
        if offset:
            df = df.iloc[offset:]
            logger.info(f"Offset appliqué: {offset} lignes sautées")
        if limit:
            df = df.iloc[:limit]
            logger.info(f"Limit appliqué: {limit} lignes maximum")

        # Connexion à la base de données
        conn = connect_to_db()
        cursor = conn.cursor()

        # Préparation de la requête d'insertion
        insert_query = """
            INSERT INTO bridge_meteore_dipole_bt (
                gdo,
                code_gdo_ds,
                statut,
                date_creation_sig,
                date_maj,
                created_at
            ) VALUES (
                %s, %s, %s, %s, %s, NOW()
            )
        """
        logger.debug(f"Requête d'insertion préparée: {insert_query}")

        # Traitement des lignes
        rows_inserted = 0
        for index, row in df.iterrows():
            try:
                values = (
                    row.get('GDO', None),
                    row.get('CODE_GDO', None),
                    row.get('STATUT', None),
                    pd.to_datetime(row.get('DATE_CREATION_SIG', None)) if pd.notna(row.get('DATE_CREATION_SIG')) else None,
                    pd.to_datetime(row.get('DATE_MAJ_DANS_SIG', None)) if pd.notna(row.get('DATE_MAJ_DANS_SIG')) else None
                )
                logger.debug(f"Insertion ligne {index}: {values}")
                cursor.execute(insert_query, values)
                rows_inserted += 1
                if rows_inserted % 100 == 0:
                    logger.info(f"{rows_inserted} lignes insérées...")
            except Exception as e:
                logger.error(f"Erreur lors de l'insertion de la ligne {index}: {row.to_dict()}")
                logger.error(f"Erreur: {str(e)}")
                continue

        # Validation des changements
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
        # Nettoyage du dossier temporaire si créé
        if temp_dir and os.path.exists(temp_dir):
            shutil.rmtree(temp_dir)
            logger.info(f"Dossier temporaire supprimé: {temp_dir}")

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