#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
echo $BASEDIRECTORY
echo $STACKNAME

source $PARENTDIR/.env

./reset_app_prefix.sh

echo "INSTANCEURL=https://$DOMAIN/$PREFIX" > .env
SED_CMD='s/STACKNAME/'${PREFIX}'/g'
sed -i $SED_CMD nginx.conf
