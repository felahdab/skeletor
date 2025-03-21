#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
APPDIRECTORY=$BASEDIRECTORY/..

echo -e "Regenerate application .env files\n"


cd $APPDIRECTORY
if [ ! "$?" -eq 0 ]; then
    echo -e "\n${I_ERROR}${S_ERROR} cd to application directory failed.${RESET}" >&2
    exit 1
fi 

if [ ! -f ../.env ]; then
    echo -e "\n${I_ERROR}${S_ERROR} .env file not found!.${RESET}" >&2
    exit 1

fi

source ../.env
echo "Domaine:       "$DOMAIN
echo "Prefixe:       "$PREFIX
echo "Environnement: "$ENVIRONNEMENT

APP_VERSION=$(cat VERSION)

SED_CMD='s/APP_PREFIX=.*/APP_PREFIX='$PREFIX'/g; s/APP_VERSION=.*/APP_VERSION='$APP_VERSION'/g'
sed "$SED_CMD" .env.dev.slug > .env.dev
sed "$SED_CMD" .env.testing.slug > .env.testing
sed "$SED_CMD" .env.production.slug > .env.production
sed "$SED_CMD" .env.dusk.dev.slug > .env.dusk.dev

cp -a .env.${ENVIRONNEMENT} .env
SED_CMD='s/APP_PREFIX=.*/APP_PREFIX='$PREFIX'/g'
sed -i $SED_CMD .env

#mv public/assets public/$PREFIX
cd public
if [ -L $PREFIX ]; then
    rm $PREFIX
fi
ln -s ./assets $PREFIX

echo -e "Application initialize_env_files done\n"