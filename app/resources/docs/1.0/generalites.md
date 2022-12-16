# Généralités

- Besoin initial
- Le parcours de transformation
- Les rôles
- Interface utilisateur

## Besoin initial
FFAST (Frégates Fortement Automatisé - Suivi de la Transformation) est une application conçue faciliter le suivi du parcours de transformation des marins destinés à être affectés à bord des frégates fortement automatisés.  

Plus besoin de mettre à jour des fichiers bloqués par un autre utilisateur parti sans fermer Excel. FFAST est disponible tout le temps depuis n'importe quel poste Intradef.

Même si FFAST a été conçu initialement pour les besoins des GTR et des FREMM, sa structure générique lui permet de s'adapter à d'autre structures ayant besoin de suivre l'avancement des actions de formations auprofit d'un groupe d'élèves.

## Le parcours de transformation
Le coeur de FFAST est constitué par le parcours de transformation.
Ce parcours, stocké en base de données est totalement configurable.
Chaque marin dont on souhaite suivre la progression se voit attribuer une ou plusieurs fonctions. Chacune de ces fonctions se compose de compagnonages, eux mêmes composés de taches, elles-même composées d'objectifs, eux-mêmes décomposés en sous-objectifs.
Cela peut paraitre compliqué, mais l'application n'impose rien de plus que de respecter cette structure.
Par conséquent, une fonction peut être composée d'un seul compagnonage, lui-même composé d'une seule tache, elle-même composée d'un seul objectif comportant un seul sous-objectif. Dans un tel scénario, la réalisation du sous-objectif revient à valider la fonction.
Mais on peut aussi décrire une fonction comme comportant de nombreux compagnonages, de nombreuses taches, de nombreux objectifs et de très nombreux sous-objectifs, permettant alors un suivi aussi fin qu'on le souhaite du parcours de transformation.  
En outre, chaque fonction peut se voir attribuer des stages devant normalement être validés pour que la fonction puisse être considére comme acquise.

> {info} Chaque fonction comporte éventuellement 1 ou plusieurs stages et dans tous les cas au moins 1 compagnonage. Chaque compagnonage comporte au moins 1 tâche. Chaque tâche comporte au moins 1 objectif. Chaque objectif comporte au moins 1 sous-objectif.

## Les rôles
Dans FFAST, chaque utilisateur se voit attribuer un ou plusieurs rôles qui déterminent les actions pouvant être réalisées.
Par défaut, les rôles suivants existent:

| Role    | Actions possibles | 
| :       |   :    | 
| user    | Peut se connecter a l'application, et prendre connaissance de son avancement, si une fonction (au sens parcours de transformation) lui a été attribuée. Tous les utilisateurs se voient normalement atribuer ce rôle. |
| admin   | Peut tout faire, notamment crééer les comptes utilisateurs (appelés Fiches des marins) ou encore envoyer des mails aux utilisateurs ayant un compte dans l'application.  | 
| tuteur  | Peut valider ou dévalider des morceaux des parcours de transformation attribués aux utilisateurs.  | 
| 2ps     | Peut suivre la situation des stages, valider ou dévalider un stage pour 1 ou plusieurs marins. | 
| em      | Peut consulter les différents tableaux de bord et bilans pour superviser l'activité de transformation. | 

Là encore, la structure de FFAST est très générique. L'application définit des permissions, associées à chaque action qu'un utilisateur pour réaliser.
Chaque rôle se voit attribuer 0, 1 ou plusieurs de ces permissions.
Et chaque utilisateur se voit attribuer 0, 1 ou plusieurs rôles.
Les actions qu'un utilisateur peut accomplir sont donc la somme de toutes les permissions dont il bénéficient au travers des roles qu'on lui attribue.

## Interface utilisateur

# TODO: insérer une capture d'écran d'une page

L'interface utilisateur de FFAST orbite autour de la barre de navigation située en haut de l'écran.
Cette barre rassemble toutes les fonctions auxquelles l'utilisateur a accès.
Avant que l'utilisateur se connecte, aucune fonction n'est accessible.
Une fois connecté, les menus apparaissent en fonction des roles, et donc des permissions, de l'utilisateur.

Ce principe est également appliqué dans tous les écrans de l'application: si un utilisateur voit un élément dans la page (un bouton, un lien, etc...) c'est qu'il bénéficie de la permission associée à l'action.

> {info} Les éléments affichés à l'écran sont directement liés aux rôles attribués, et donc aux permissions de l'utilisateur.

La barre de navigation comporte 2 éléments importants:
- le bouton d'aide (qui permet à l'utilisateur de rejoindre la page de documentation en ligne correspondant à la page depuis laquelle il clique sur le lien).
- le bouton "Signaler un problème" permettant à l'utilisateur de faire part de ses remarques ou de ses difficultés à l'équipe d'administration technique qui s'efforcera de l'aider ou de résoudre le problème.

