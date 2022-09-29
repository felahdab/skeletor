#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)
# echo $BASEDIRECTORY
# echo $STACKNAME

./reset_app_prefix.sh

APP_PREFIX=$1

SED_CMD='s/APP_PREFIX=.*/APP_PREFIX='$1'/g'
sed -i $SED_CMD .env

mv public/assets public/$APP_PREFIX