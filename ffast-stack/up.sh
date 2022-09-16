#!/bin/bash

CURRENTDIR=$(pwd)
PARENTDIR=$(dirname $CURRENTDIR)
STACKNAME=$(basename $PARENTDIR)
echo $STACKNAME

docker compose -p $STACKNAME up -d