# Docker - build to target
TARGETPLATFORM=linux/arm64 docker-compose up -d --build
# Docker - open instance terminal
docker-compose exec app bash

# Prodside - DB backup command
mysqldump --single-transaction=TRUE -u joz -p somnivores > ~/backups/mydatabase_backup.sql
# Copy file to your machine
scp -r joz@somnivores.com:~/backups/mydatabase_backup.sql /Users/work-me/Documents/somni_assets/backups/
# Localside - Implement the exported backup file
mysql --port=3306 --host=127.0.0.1 -u root -proot lorekeeper < /Users/work-me/Documents/somni_assets/backups/mydatabase_backup.sql

# Copy all Prod DB Images to local
<!-- scp -r joz@somnivores.com:~/somnivores.com/www/public /Users/work-me/Documents/somni_assets/remote_imgs/ -->
rsync -av --ignore-existing joz@somnivores.com:~/somnivores.com/www/public /Users/work-me/Documents/somni_assets/remote_imgs/
cp -R /Users/work-me/Documents/somni_assets/remote_imgs/public/ /Users/work-me/Documents/code/lorekeeper/lorekeeper_3/public





scp -r joz@somnivores.com:~/backups/mydatabase_backup.sql /Users/work-me/Documents/somni_assets/backups/
mysql --port=3306 --host=127.0.0.1 -u root -proot lorekeeper < /Users/work-me/Documents/somni_assets/backups/mydatabase_backup.sql
rsync -av --ignore-existing joz@somnivores.com:~/somnivores.com/www/public /Users/work-me/Documents/somni_assets/remote_imgs/
cp -R /Users/work-me/Documents/somni_assets/remote_imgs/public/ /Users/work-me/Documents/code/lorekeeper/lorekeeper_3/public
