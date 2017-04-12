#!/usr/bin/env bash

set -eux

apt-get purge -qq '^mysql*' '^libmysql*'
rm -fr /etc/mysql
rm -fr /var/lib/mysql
apt-key adv --keyserver pgp.mit.edu --recv-keys 5072E1F5
add-apt-repository 'deb http://repo.mysql.com/apt/ubuntu/ trusty mysql-5.7'
apt-get update -qq
apt-get install -qq mysql-server libmysqlclient-dev

# https://www.percona.com/blog/2016/03/16/change-user-password-in-mysql-5-7-with-plugin-auth_socket/
mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY ''"
