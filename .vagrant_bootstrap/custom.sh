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

#################### FOR WINDOWS ONLY
# Remove NFS in that case in VagrantFile
# After that create "nouveau lecteur réseau" by clicking right on Computer. Add \\192.168.100.10\shared as the server log/password are vagrant/vagrant

# # Installing Samba
# SAMBA_USER="vagrant"
# SAMBA_PASSWORD="vagrant"
# apt-get install -y samba
# service smbd stop
# # Configure Samba
# rm -rf /etc/samba/smb.conf
# cp /vagrant/.configs/samba/smb.conf.dist /etc/samba/smb.conf
# service smbd start
# # Configure user
# echo -ne "$SAMBA_PASSWORD\n$SAMBA_PASSWORD\n" | smbpasswd -L -a $SAMBA_USER
# smbpasswd -L -e $SAMBA_USER
 
# # Finally, give all rights
# chmod 777 -R /var/www
# chown -R $SAMBA_USER:$SAMBA_USER
# # Setting apache2 user and group to samba user
# sed "s#export APACHE_RUN_USER=.*#export APACHE_RUN_USER=$SAMBA_USER#g" /etc/apache2/envvars > /etc/apache2/envvars.tmp
# mv /etc/apache2/envvars.tmp /etc/apache2/envvars
# sed "s#export APACHE_RUN_GROUP=.*#export APACHE_RUN_GROUP=$SAMBA_USER#g" /etc/apache2/envvars > /etc/apache2/envvars.tmp
# mv /etc/apache2/envvars.tmp /etc/apache2/envvars

######################## END FOR WINDOWS ONLY