#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

$BASEDIRECTORY/app/reset_app_prefix.sh
$BASEDIRECTORY/ffast-stack/reset_app_prefix.sh