DB_FILE="/var/www/html/database/db/database.sqlite"

# Check if directory exists, if not create it
if [ ! -d "/var/www/html/database/db" ]; then
  mkdir -p "/var/www/html/database/db"
  echo "Created database directory"
fi

# Check if file exists
if [ ! -f "$DB_FILE" ]; then
  touch "$DB_FILE"
  chmod 755 "$DB_FILE"
  echo "Created SQLite database file at $DB_FILE"
else
  echo "SQLite database file already exists at $DB_FILE"
fi
php artisan migrate --force


