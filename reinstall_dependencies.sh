#!/bin/bash

composer install 
./artisan dusk:install
rm tests/Browser/ExampleTest.php
