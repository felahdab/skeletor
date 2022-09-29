#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

APP_PREFIX=$1

$BASEDIRECTORY/app/bump_app_prefix.sh $APP_PREFIX
$BASEDIRECTORY/ffast-stack/bump_app_prefix.sh $APP_PREFIX
