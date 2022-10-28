#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
cd $BASEDIRECTORY

chown -R :ffastdev *
chown -R :ffastdev .*
chmod -R g+rwx .
chmod -R o+rx .
chmod -R o+rwx storage/logs
chmod -R o+rwx storage/debugbar
chmod -R o+rwx storage/framework
chmod -R o+rwx bootstrap/cache
chmod -R o+rwx vendor/mpdf/mpdf/tmp
