import csv
import json
import os
import sqlite3
import sys

DB_FILE = os.environ.get('CSV_IMPORT_DB', os.path.join(os.path.dirname(__file__), '..', 'var', 'data_import.db'))
TABLE_NAME = 'csv_records'


def setup_db(conn):
    conn.execute(f"CREATE TABLE IF NOT EXISTS {TABLE_NAME} (id INTEGER PRIMARY KEY AUTOINCREMENT, data TEXT)")
    conn.commit()


def import_csv(path):
    conn = sqlite3.connect(DB_FILE)
    setup_db(conn)
    with open(path, newline='') as csvfile:
        reader = csv.DictReader(csvfile)
        rows = [json.dumps(row) for row in reader]
        conn.executemany(f"INSERT INTO {TABLE_NAME} (data) VALUES (?)", [(r,) for r in rows])
        conn.commit()
    conn.close()


def main():
    if len(sys.argv) < 2:
        print('Usage: csv_import.py <csv_file>')
        sys.exit(1)
    import_csv(sys.argv[1])


if __name__ == '__main__':
    main()
