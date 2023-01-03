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

SED_CMD='s/APP_PREFIX=.*/APP_PREFIX=""/g'

sed -i $SED_CMD .env
sed -i $SED_CMD .env.dusk.testing
sed -i $SED_CMD .env.production
sed -i $SED_CMD .env.testing

cd public
rm -f $PREFIX
