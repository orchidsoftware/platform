#!/bin/sh

apt-key adv --keyserver pgp.mit.edu --recv-keys 5072E1F5
add-apt-repository 'deb http://repo.mysql.com/apt/ubuntu/ trusty mysql-5.7'
apt-get update -qq
apt-get install -qq mysql-server libmysqlclient-dev
