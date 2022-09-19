#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)
echo $BASEDIRECTORY
echo $STACKNAME

docker compose -p $STACKNAME down 
docker volume rm ${STACKNAME}_mysqldata