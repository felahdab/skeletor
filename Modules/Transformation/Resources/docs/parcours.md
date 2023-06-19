# Parcours

- [Fonctions](#fonctions)
- [Compagnonnages](#compagnonnages)
- [Tâches](#taches)
- [Objectifs](#objectifs)
- [Ordre d'afficgage](#ordre-affichage)
- [Stages](#stages)
- [Exporter les parcours](#export_parcours)

Ce menu permet d’accéder à l'ensemble des composants du parcours de transformation.

> {info} **  Rappel : ** 
> - Chaque fonction comporte éventuellement 1 ou plusieurs stages et dans tous les cas au moins 1 compagnonnage. Chaque compagnonnage comporte au moins 1 tâche. Chaque tâche comporte au moins 1 objectif. Chaque objectif comporte au moins 1 sous-objectif.
> - n'importe quel objet du parcours peut servir plusieurs fois : par exemple, un compagnonnage peut être utilisé par plusieurs fonctions.

<a name="fonctions">
## Fonctions
Vous retrouvez la liste de toutes les fonctions (1). Un filtre (2) permet d’affiner l’affichage.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/parcours/liste_fonctions.png' )) }}">

(3) « Ajouter une fonction » pour créer une nouvelle fonction.  
(4) « Consulter une fonction » pour visualiser une fonction.  
(5) « Modifier » les données de la fonction.  
(6) « Supprimer » la fonction.  

> {info} ** Remarques: **
> - Ajout : Il faut compléter et valider le formulaire avant de pouvoir associer des compagnonnages et des stages à la fonction.
> - Suppression : La suppression d'une fonction n'entraine pas la suppression des compagnonnages ou stages associés.

<a name="compagnonnages">
## Compagnonnages
Vous retrouvez la liste de tous les compagnonnages (1). Un filtre (2) permet d’affiner l’affichage.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/parcours/liste_comps.png' )) }}">

(3) « Ajouter un compagnonnage » pour créer un nouveau compagnonnage.  
(4) « Consulter » pour visualiser un compagnonnage.  
(5) « Modifier » les données du compagnonnage.  
(6) « Supprimer » le compagnonnage.

> {info} ** Remarques: **
> - Ajout : Il faut compléter et valider le formulaire avant de pouvoir associer des tâches au compagnonnage.
> - Suppression : La suppression d'un compagnonnage n'entraine pas la suppression des fonctions ou tâches associées.


<a name="taches">
## Tâches
Vous retrouvez la liste de toutes les tâches (1). Un filtre (2) permet d’affiner l’affichage.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/parcours/liste_taches.png' )) }}">

(3) « Ajouter une tâche » pour créer une nouvelle tâche.  
(4) « Consulter » pour visualiser une tâche.  
(5) « Modifier » les données de la tâche.  
(6) « Supprimer » la tâche.


> {info} ** Remarques: **
> - Ajout : Il faut compléter et valider le formulaire avant de pouvoir associer des objectifs à la tâche.
> - Suppression : La suppression d'une tâche n'entraine pas la suppression des compagnonnages ou objectifs associés.

<a name="objectifs">
## Objectifs
Vous retrouvez la liste de tous les objectifs (1). Un filtre (2) permet d’affiner l’affichage.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/parcours/liste_objectifs.png' )) }}">

(3) « Ajouter un objectif » pour créer un nouvel objectif.  
(4) « Consulter » pour visualiser un objectif.  
(5) « Modifier » les données de l'objectif.  
(6) « Supprimer » l'objectif.

> {info} ** Remarques: **
> - Ajout : Il faut compléter et valider le formulaire avant de pouvoir associer des sous-objectifs à l'objectif.
> - Suppression : La suppression d'un objectif **entraine la suppression** des sous objectifs qui lui sont associés.

<a name="ordre-affichage">
## Ordre d'afficgage

Pour chaque élément du parcours de transformation (Fonction, Compagnonnage, Tache et Objectif), la page d'édition permet de
définir l'ordre d'affichage des éléments constitutifs dans les différentes pages de l'application (notamment dans le livret
de transformation et la page de suivi par compagnonage).

Pour cela, il suffit de déplacer les éléments avec la souris (cliquer sur l'élément à déplacer puis, tout en maintenant le
bouton de la souris enfoncé, déplacer l'élément vers le haut ou vers le bas puis relacher le bouton).
Une fois l'ordre désiré obtenu à l'écran, cliquer sur le bouton "Enregistrer" pour sauvegarder l'ordre en base de donnée.  

Cette possibilité est rappelée dans chacune des pages concernée (voir ci-dessous la page de mofification des objectifs).  

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/parcours/modification-ordre-elements-du-parcours.png' )) }}">

<a name="stages">
## Stages
Vous retrouvez la liste de tous les stages (1). Des filtres (2) permettent d’affiner l’affichage.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/parcours/liste_stages.png' )) }}">

(3) « Ajouter un stage » pour créer un nouveau stage.  
(4) « Modifier » les données du stage.  
(5) « Supprimer » le stage.

> {info} ** Remarques: **
> L'association d'un stage à une fonction se fait uniquement dans le menu "Fonctions"



<a name="export_parcours">
## Exporter les parcours
Ce menu permet de créer un fichier Excel qui contient un onglet pour chaque compagnonnage existant. Dans chaque onglet, on retrouve les tâches/objectifs/sous-objectifs associés au compagnonnage.


