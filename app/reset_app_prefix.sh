#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)
# echo $BASEDIRECTORY
# echo $STACKNAME

sed -i 's/APP_PREFIX=.*/APP_PREFIX=""/g' .env

cd public
find . -mindepth 1 -maxdepth 1 ! -path ./assets -type d -exec mv {} assets \;
