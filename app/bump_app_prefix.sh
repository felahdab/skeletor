#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)
# echo $BASEDIRECTORY
# echo $STACKNAME

./reset_app_prefix.sh

source $PARENTDIR/.env
echo $DOMAIN
echo $PREFIX
echo $ENVIRONNEMENT

SED_CMD='s/APP_PREFIX=.*/APP_PREFIX='$PREFIX'/g'
sed $SED_CMD .env.dev.slug > .env.dev
sed $SED_CMD .env.testing.slug > .env.testing
sed $SED_CMD .env.production.slug > .env.production
sed $SED_CMD .env.dusk.dev.slug > .env.dusk.dev

cp -a .env.${ENVIRONNEMENT} .env
SED_CMD='s/APP_PREFIX=.*/APP_PREFIX='$PREFIX'/g'
sed -i $SED_CMD .env

#mv public/assets public/$PREFIX
cd public
ln -s ./assets $PREFIX
