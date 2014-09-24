#!/usr/bin/env bash
 
# Apache VHOST
# ------------
cp /vagrant/.configs/apache2/vhosts/symfony.config.dist /etc/apache2/sites-available/000-default.conf
 
apt-get update
 
# Configure & clean shared folder
rm -rf /var/www
mkdir /var/www
 
# Fetching project
cd /var/www
 
# Composer stuff
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
 
# Installing Symfony
# But can't do it since you need prompt details (confirmation dialog for configuration)
composer create-project symfony/framework-standard-edition $APPLICATION_NAME/ "2.5.*"
sed "s#'127.0.0.1', 'fe80::1', '::1'#'192.168.100.1', '127.0.0.1', 'fe80::1', '::1'#g" /var/www/$APPLICATION_NAME/web/app_dev.php > /var/www/$APPLICATION_NAME/web/app_dev.php.tmp
mv /var/www/$APPLICATION_NAME/web/app_dev.php.tmp /var/www/$APPLICATION_NAME/web/app_dev.php
sed "s#'127.0.0.1',#'192.168.100.1', '127.0.0.1',#g" /var/www/$APPLICATION_NAME/web/config.php > /var/www/$APPLICATION_NAME/web/config.php.tmp
mv /var/www/$APPLICATION_NAME/web/config.php.tmp /var/www/$APPLICATION_NAME/web/config.php
service apache2 reload
 
# Add config for xDebug
echo "xdebug.max_nesting_level = 250" >> /etc/php5/apache2/php.ini
