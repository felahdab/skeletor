#!/bin/bash

./reset_app_prefix.sh

APP_PREFIX=$1

SED_CMD='s/APP_PREFIX=.*/APP_PREFIX='$1'/g'

sed -i $SED_CMD .env
mv public/assets public/assets$APP_PREFIX