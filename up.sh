#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

STACKNAME=$(basename $(pwd))
echo $BASEDIRECTORY
echo $STACKNAME

$BASEDIRECTORY/app/adjust_permissions.sh
$BASEDIRECTORY/ffast-stack/up.sh
$BASEDIRECTORY/app/adjust_permissions.sh
