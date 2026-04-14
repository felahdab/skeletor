# Bienvenue dans la documentation de ce serveur POSEIDON

## Si vous savez déjà ce que c'est

Si vous savez déjà ce que signifie POSEIDON, vous pouvez directement cliquer sur les pages de documentation des modules hébergés sur ce serveur, situés à gauche de la page.

Vous pouvez aussi rechercher directement dans la documentation en utilisant la barre de recherche en haut à droite de la page.

Si vous voulez comprendre ce que signifie POSEIDON, continuez la lecture.

## C'est quoi POSEIDON ?

POSEIDON est un projet de transformation de la Force d'Action Navale.  

L'objectif est de développer et de déployer un système d'information organique pour donner aux marins les outils modernes dont ils ont besoin pour réaliser leurs tâches du quotidien tout en contribuant à la structuration des données de la FAN.  

En pratique, l'objectif est de déployer un serveur POSEIDON pour chaque unité de la FAN, et d'équiper ces serveurs avec les modules métiers adaptés aux besoins des différents types d'unités.

De son côté, l'état-major de la FAN dispose de son serveur avec ses propres modules métiers, notamment ceux permettant de générer une vision de synthèse permettant le pilotage organique.

## POSEIDON, Skeletor, FFAST, ... c'est quoi tout ça ?

La stratégie de développement de POSEIDON est construite sur le retour d'expérience du projet FFAST, conduit initialement au sein du Groupe de Transformation et de Renfort de Toulon.

### Le suivi de la transformation dans les GTR

En 2022/2023, le GTR de Toulon a développé le logiciel FFAST (Frégates Fortement Armées, Suivi de la Transformation). Ce logiciel avait pour objectif de remplacer les multiples fichiers excel qui étaient utilisés au quotidien pour suivre la progression des marins placés en transformation avant d'être affectés sur FREMM.  

Il est rapidement apparu que le développement de FFAST avait nécessité:

- le développement d'une base applicative permettant de gérer les comptes utilisateurs, l'authentification Mindef Connect, l'envoi de mails, les sauvegardes, la mise en ligne de la documentation, etc...
- le développement de la partie spécifique au suivi de la transformation.

### La naissance de Skeletor

Une fois ce constat fait, FFAST a été modifié pour vraiment séparer ces deux parties.  

La partie générale est devenue un framework applicatif constituant un squelette d'application générique. Ce framework a été appelé Skeletor.  
La partie spécifique à la transformation est devenue un module métier: le module de Transformation.

On peut donc dire que FFAST = Skeletor + le module de Transformation.

### Les expériences successives

Depuis 2023, Skeletor a été enrichi progressivement, en particulier pour améliorer "l'expérience développeur", c'est à dire pour rendre les tâches nécessaires au développement de nouveaux modules métier les plus simples, rapides et agréables possibles.  
De nouveaux modules métiers ont été implémentés et mis en oeuvre ponctuellement ou de façon permanente:

- Le module Fleetprogram est en production sur SIC21, et a remplacé le fichier Excel de suivi des activités de préparation opérationnelle et d'exercice interarmés et interalliés tenu à jour par la cellule FLEETPROGRAM.
- Un module d'aide à la direction d'exercice a été développé et temporairement déployé à l'occasion de l'exercice POLARIS 25.

Ces expériences ont permet d'affiner les besoins rencontrés sur des cas réels pour le framework Skeletor.

### L'évolution de la FAN et l'apparaition de la FCM

En parallèle de l'évolution logicielle de Skeletor, l'organisation de la FAN a évolué:

- Les GTR ont cédé la place aux Flotilles de Perfectionnement des Surfacier, et la transformation réalisée au sein des GTR a pris fin.
- La FAN a commencé à mettre progressivement en oeuvre la Formation Continue Modulaire.

C'est donc tout naturellement que les travaux ont commencé pour implémenter des modules métiers permettant d'outiller la FCM sur le même modèle.

### Le projet POSEIDON

A la lumière des expériences réussies de suivi de la transformation, puis d'outillage de la FCM, il est apparu qu'il devenait possible d'imaginer de développer d'autres modules métiers destinés à apporter des outils permettant aux marins de la FAN de remplir leurs missions de façon plus agréable, moderne et efficace.  

C'est pour cela que la FAN a lancé le projet POSEIDON (Pilotage Organisé des Systèmes et Echanges de Données Organiques Navales).  

L'idée, c'est de faire le nécessaire pour pouvoir déployer un serveur POSEIDON pour chaque unité relevant organiquement de la FAN, aussi bien les unité embarquées que les unités à terre, et de mettre en place les outils et l'organisation permettant à la FAN de développer les modules métiers nécessaires à l'outillage de ses processus organiques.

Ce projet est en cours. Pour en savoir plus, vous pouvez vous rendre sur [la chaine DefTube POSEIDON](https://deftube.intradef.gouv.fr/channels/#poseidon).
