#!/bin/bash
apt-get install -y language-pack-en-base
LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php5
add-apt-repository "deb http://archive.ubuntu.com/ubuntu $(lsb_release -sc) universe"

apt-get update

apt-get install php5 php5-curl ruby1.9.3 ruby-dev gem cucumber
gem install selenium-webdriver
