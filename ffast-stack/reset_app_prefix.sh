#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)


echo -n "" > .env
sed -i '/pma/c\    location ^~ /STACKNAME/pma/ {' nginx.conf
sed -i '/location.*worker/c\    location ^~ /STACKNAME/worker/ {' nginx.conf
sed -i '/rewrite/c\        rewrite /STACKNAME/worker/(.*) /$1 break;' nginx.conf
