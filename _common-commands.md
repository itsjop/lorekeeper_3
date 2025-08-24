# Docker - build to target
TARGETPLATFORM=linux/arm64 docker-compose up -d --build
# Docker - open instance terminal
docker-compose exec app bash
# Prodside - DB backup command
mysqldump --single-transaction=TRUE -u joz -p somnivores > ~/backups/mydatabase_backup.sql
# Localside - Implement the exported backup file
mysql --port=3306 --host=127.0.0.1 -u root -proot lorekeeper < /Users/work-me/Documents/somni_assets/mydatabase_backup.sql
