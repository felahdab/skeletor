#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

STACKNAME=$(basename $(pwd))
echo $BASEDIRECTORY
echo $STACKNAME

PREFIX=$1

exit 
./up.sh

$BASEDIRECTORY/app/bump_app_prefix.sh $PREFIX
