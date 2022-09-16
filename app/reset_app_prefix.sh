#!/bin/bash

sed -i 's/APP_PREFIX=.*/APP_PREFIX=""/g' .env

ls public/ | grep asse | while read dirname 
do
    if [ $dirname != "assets" ]
    then
        mv public/$dirname public/assets
    fi
done