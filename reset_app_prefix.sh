#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)
# echo $BASEDIRECTORY
# echo $STACKNAME

if [ -f .env ]; then
    SED_CMD='s/APP_PREFIX=.*/APP_PREFIX=""/g'
    sed -i $SED_CMD .env
fi

if [ -f $PARENTDIR/.env ]; then
    source $PARENTDIR/.env
    cd public
    rm -f $PREFIX
fi


