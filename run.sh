#!/bin/bash
#
# Execute composer & start service with PHP build-in server.
#
export TERM=linux

reldir=`dirname $0`
cd $reldir

sudo service nginx stop

sudo composer install

cd public

sudo php -S 0.0.0.0:80
