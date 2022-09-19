#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)
echo $BASEDIRECTORY
echo $STACKNAME

sed -i 's/APP_PREFIX=.*/APP_PREFIX=""/g' .env

ls public/ | grep asse | while read dirname 
do
    if [ $dirname != "assets" ]
    then
        mv public/$dirname public/assets
    fi
done