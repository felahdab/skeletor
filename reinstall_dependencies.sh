#!/bin/bash

# Dans l'hypothèse où une réinstallation totale des dépendances (dossier vendor), ce script fait le nécessaire en complément:
# - installation du binaire dusk adapté
# - retrait du test d'example de dusk

composer install 
./artisan dusk:install
rm tests/Browser/ExampleTest.php
