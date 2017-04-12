#!/usr/bin/env bash
sudo service mysql stop || echo "mysql not stopped"
sudo stop mysql-5.6 || echo "mysql-5.6 not stopped"
echo mysql-apt-config mysql-apt-config/select-server select mysql-5.7 | sudo debconf-set-selections
wget http://dev.mysql.com/get/mysql-apt-config_0.7.3-1_all.deb
sudo dpkg --install mysql-apt-config_0.7.3-1_all.deb
sudo apt-get update -q
sudo apt-get install -q -y -o Dpkg::Options::=--force-confnew mysql-server
sudo mysql_upgrade
