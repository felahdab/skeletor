# Skeletor

## Description

Skeletor est une application Laravel pré-configurée pour faciliter le développement collaboratif de modules métiers. Son objectif est de faciliter le démarrage de projets de développement pour des développeurs peu expérimentés, ou ne maitrisant pas les contraintes de déploiement de l'environnement cible. 

Ainsi, en développant un module dans Skeletor, le développeur n'a pas à se soucier de l'intégration système et bénéficie dès le premier instant de l'authentification centralisé (Open ID) et d'une base d'utilisateur locale, d'un système de gestion des persmissions et des roles, et de divers services communs.

Skeletor permet la création d'un nouveau module disposant d'un panneau Filament en quelques minutes.

Le développeur doit ensuite suivre les consignes renseignées dans le fichier resources/docs/Skeletor/developpement.md pour faciliter la reprise de son travail ultérieurement.

Skeletor reste toutefois une application Laravel tout à fait normale. Ainsi, le développeur peut aussi avoir recours aux méthodes classiques de développement Laravel s'il le souhaite.

## Installation Rapide

1. Copier le fichier .env.docker d'exemple

```bash
cp .env.docker .env
```

2. Lancer les conteneurs via le fichier docker-compose.yml

```bash
cd docker
docker compose up -d
```

3. Connectez-vous au conteneur PHP et exécutez les commandes suivantes :

```bash
# Se connecter au conteneur
docker compose exec php bash

# Commandes
composer install --ignore-platform-req=ext-gd
chmod -R 777 storage bootstrap/cache
./artisan key:generate
./artisan migrate --seed
./artisan storage:link

# Ces commandes ont respectivement pour rôle :
# d'installer les dépendances manquantes (fichiers autoload)
# changer les permissions du fichier de stockage (pour écriture de logs)
# générer la clé artisan
# exécuter les migrations de la base de données
# lier le dossier public et storage pour donner accès aux assets à nginx
```

4. Rendez-vous à l'adresse `http://localhost/apps`

5. Pour créer un module, exécutez la commande :

```bash
# A l'intérieur du conteneur, pour s'y connecter :
docker compose exec php bash

./artisan module:make mon_module
# Ensuite spécifier le nom, etc
```