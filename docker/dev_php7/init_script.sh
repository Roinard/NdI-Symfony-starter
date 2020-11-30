#!/bin/bash

apache_status=`service apache2 status | grep "not running" | wc -l`
mysql_status=`service mysql status | grep stopped | wc -l`
init_status=`file first_init_ok | grep "text" | wc -l`

if [ $apache_status -eq 1 ]; then
    service apache2 start
    while [ `service apache2 status | grep "not running" | wc -l` -eq 1 ];  do
        sleep 1
    done
fi

if [ $mysql_status -eq 1 ]; then
    service mysql start
    while [ `service mysql status | grep stopped | wc -l` -eq 1 ];  do
        sleep 1
    done
fi
mysql < /root/root_password.sql


if [ $init_status -eq 0 ] || [ "$1" == "-r" ]; then
    php /var/www/app/bin/console doctrine:database:create
    php /var/www/app/bin/console doctrine:schema:update --force
    php /var/www/app/bin/console doctrine:fixtures:load --append
    chown -R www-data:www-data /var/www/app/var/cache
    chown -R www-data:www-data /var/www/app/var/log
    touch first_init_ok && echo "ok" >> first_init_ok
fi

init_log_arpege_access_status=`file /logs/arpege_access.log | grep "text" | wc -l`
if [ $init_log_arpege_access_status -eq 0 ]; then
    touch /logs/arpege_access.log
fi

echo "Job's done ! Let's see the Apache logs :"
tail -f /logs/arpege_access.log
