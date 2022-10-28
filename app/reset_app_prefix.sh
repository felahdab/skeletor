#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)
# echo $BASEDIRECTORY
# echo $STACKNAME

source $PARENTDIR/.env
echo $DOMAIN
echo $PREFIX

sed -i 's/APP_PREFIX=.*/APP_PREFIX=""/g' .env

cd public
rm -f $PREFIX
