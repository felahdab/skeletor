#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

PARENTDIR=$(dirname $BASEDIRECTORY)
STACKNAME=$(basename $PARENTDIR)
echo $BASEDIRECTORY
echo $STACKNAME

docker compose -p $STACKNAME up -d

echo "Waiting 10 seconds before initializing database and seeding data."
sleep 10
docker exec -it ${STACKNAME}-php-1 ./artisan migrate --force
docker exec -it ${STACKNAME}-php-1 ./artisan db:seed --force
