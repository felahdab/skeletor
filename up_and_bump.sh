#!/bin/bash

PREFIX=$1

./up.sh

cd app
./bump_app_prefix.sh $PREFIX
