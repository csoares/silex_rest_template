#!/bin/bash
echo -n MySQL Username:
read username
echo -n MySQL Password:
stty -echo
read password
stty echo
# Run Command
echo
mysql -u$username  -p$password < db.sql 2>/dev/null
composer install

read -p "Do you wish to install the virtual host in apache2? (y/n)?" RESP
if [ "$RESP" = "y" ]; then
    cat << EOF | sudo tee -a /etc/apache2/sites-available/default.conf
<VirtualHost *:80>
    DocumentRoot /var/www/app/silexrest/public
    ServerName api.dev
</VirtualHost>
EOF
    service apache2 stop
    service apache2 start
fi
