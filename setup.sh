#!/bin/bash
#
# Execute composer & start service with PHP build-in server.
#
export TERM=linux

reldir=`dirname $0`
cd $reldir

sudo composer install

cd scripts
php -f generate-enteties.php
