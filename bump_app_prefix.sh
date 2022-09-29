#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY


$BASEDIRECTORY/app/bump_app_prefix.sh
$BASEDIRECTORY/ffast-stack/bump_domain_and_instance.sh
