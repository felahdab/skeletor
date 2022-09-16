#!/bin/bash

chown -R :ffastdev *
chown -R :ffastdev .*
chmod -R g+rwx .
chmod -R g+rwx ../nginx.conf
chmod -R o+rx .
chmod -R o+rwx storage/logs
chmod -R o+rwx storage/framework
chmod -R o+rwx bootstrap/cache
chmod -R o+rwx vendor/mpdf/mpdf/tmp