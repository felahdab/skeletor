#!/bin/bash
SCRIPTDIRECTORY="$(dirname "$0")"
BASEDIRECTORY=$(realpath $SCRIPTDIRECTORY)
APPDIRECTORY=$BASEDIRECTORY/..
cd $APPDIRECTORY || exit 1

USERID=1111
GROUPID=1111

USERID=33
GROUPID=33

chown -R $USERID:$GROUPID *
chown -R $USERID:$GROUPID .*
chmod -R g+rwx .
# chmod -R o+rx .
# chmod -R o+rwx database/migrations
# chmod -R o+rwx storage/logs
# chmod -R o+rwx storage/debugbar
# chmod -R o+rwx storage/framework
# chmod -R o+rwx bootstrap/cache
# chmod -R o+rwx vendor/mpdf/mpdf/tmp
# chmod o+rwx storage/app/public/photos/
# chmod o+rwx storage/app/livrets/
