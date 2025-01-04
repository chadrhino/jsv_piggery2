import sqlite3
import shutil
import os

def backup_sqlite_database(db_path, backup_path):
    # Ensure the backup directory exists
    os.makedirs(os.path.dirname(backup_path), exist_ok=True)

    # Copy the database file to the backup location
    shutil.copy2(db_path, backup_path)

    print(f"Backup of SQLite database completed and saved to {backup_path}")

# Example Usage
backup_sqlite_database(
    db_path="path/to/your_database.db",
    backup_path="path/to/save/backup.db"
)
