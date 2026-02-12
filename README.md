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
# Se connecter au conteneur en tant que root
docker compose exec -it -u 0 php bash

# changer les permissions du projet
chown -R 1111:1111 .
exit

# Se connecter au conteneur
docker compose exec -it php bash

# changer les permissions du fichier de stockage (pour écriture de logs)
chmod -R 777 storage bootstrap/cache
# d'ajouter les fichiers manquantes (fichiers autoload)
composer dump-autoload
# générer la clé artisan
./artisan key:generate
# exécuter les migrations de la base de données
./artisan migrate --seed
# lier le dossier public et storage pour donner accès aux assets à nginx
./artisan storage:link
```

4. Rendez-vous à l'adresse `http://localhost/apps`, vous devriez voir la page login de Skeletor

5. Pour créer un module, exécutez la commande :

```bash
# A l'intérieur du conteneur php, pour s'y connecter :
docker compose exec -it php bash

# Créer le module
./artisan module:make mon_module

# Pour continuer votre développement classique, veuillez vous référer aux commande `module` existantes, listez les avec :
./artisan list | grep 'module'
```

6. Pour coder votre module, rendez-vous à l'adresse
`http://localhost/apps/code-editor`

Vous aurez besoin du mot de passe de code editor pour vous connecter. Ce mot de passe se trouve dans le conteneur code-editor, 
dans le fichier /home/coder/.config/code-server/config.yaml

**Pour récupérer le mot de passe code-editor :**

```bash
docker compose exec -it code-editor cat /home/coder/.config/code-server/config.yaml
```


**Pour se connecter au conteneur code-editor :**

```bash
docker compose exec -it code-editor bash
```

7. Ouvrez le dossier du projet (File > Open Folder > `/home/coder/app`), vous y trouverez Skeletor embarquant votre module