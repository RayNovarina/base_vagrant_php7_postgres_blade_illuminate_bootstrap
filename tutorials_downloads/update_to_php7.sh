#!/bin/bash
PATH=/bin:/usr/bin:

sudo apt-get remove -y php5*

sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php7.0 php7.0-fpm php7.0-gd php7.0-curl php7.0-mysql php7.0-pgsql php7.0-json

sudo chown vagrant:vagrant /var/run/php

echo " ";

read -n1 -p "Have you completed lecture 39, where we make the public folder document root for the web server? [y,n]" doit 

case $doit in  
  y|Y) sudo cp resources/default_public /etc/nginx/sites-available/default ;; 
  n|N) sudo cp resources/default /etc/nginx/sites-available/default ;; 
esac


sudo cp resources/www.conf /etc/php/7.0/fpm/pool.d

echo " ";

sudo service php7.0-fpm restart
sudo service nginx restart

echo " ";
echo  "Done. Upgraded to PHP7";