#!/bin/bash

pushd $(pwd)
cd app
./adjust_permissions.sh

popd

pushd $(pwd)
cd ffast-stack
./up.sh

popd