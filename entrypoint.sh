#!/bin/bash

set -e

# Execute wp commands
wp core download --path=/var/www/html --force --allow-root
wp config create --dbhost=mysql --dbname=yii3press --dbuser=yii3press --dbpass=secret --force --allow-root
wp core install --url=127.0.0.1:23080 --title="Yii3 Press" --admin_user=yii3press --admin_password=yii3press --admin_email=admin@localhost.com --skip-email --allow-root
wp post create --post_type=page --post_title='The Rating Form' --post_status="publish" --allow-root
wp theme activate yii3press --allow-root

composer install --working-dir=/var/www/html/wp-content/themes/yii3press

# Start Apache
apache2-foreground
