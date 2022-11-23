#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

chown -R :ffastdev *
chown -R :ffastdev .*
chmod -R g+rwx .
