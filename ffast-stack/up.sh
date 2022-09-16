#!/bin/bash

CURRENTDIR=$(pwd)
PARENTDIR=$(dirname $CURRENTDIR)
STACKNAME=$(basename $PARENTDIR)
echo $STACKNAME

docker compose -p $STACKNAME up -d

echo "Waiting 10 seconds before initializing database and seeding data."
sleep 10
docker exec -it ${STACKNAME}-php-1 ./artisan migrate --force
docker exec -it ${STACKNAME}-php-1 ./artisan db:seed --force