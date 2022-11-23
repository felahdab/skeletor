#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

$BASEDIRECTORY/app/adjust_permissions.sh
$BASEDIRECTORY/ffast-stack/adjust_permissions.sh