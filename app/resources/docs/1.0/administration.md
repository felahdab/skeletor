# Administration

- [Menu principal](#menu-principal)
- [Administration](#administration)
   - [Demandes Mindef Connect](#demandes-mindef-connect)
   - [Fiches des marins](#fiches-des-marins)
   - [Rôles](#roles)
   - [Droits d'accès](#permissions)
   - [Liens](#liens)
   - [Historique](#historique)
   - [Annudef](#annudef)
   - [Mails](#mails)


<a name="menu-principal">
# Menu principal

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/menu-principal.png' )) }}" width=1000px>

1. Menu horizontal proposant les fonctionnalités disponibles :
  - Accueil : pour revenir à la page d’accueil.
  - Administration : menu qui regroupe les fonctionnalités liées à l’administration de l’application.
  - Parcours : menu permettant de gérer tous les composants du parcours de transformation.
  - Transformation : menu pour gérer la transformation des marins de l’unité.
  - Ma transformation : Données concernant votre propre transformation. Ce menu n’apparait que si vous avez une fonction de service.
  - Statistiques : tableaux récapitulatifs des taux de transformation des marins.
2. le nom de l’utilisateur connecté est aussi un menu qui permet de se déconnecter (Logout).

** Remarque : ** les menus 1 et 2 sont accessibles depuis n’importe quel écran de l’application.

<a name="administration">
# Administration
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/menu-administration.png' )) }}" width=400px>
Ce menu permet d’accéder : 
 
1. Liste des demandes de connexion en attente de validation.
2. Liste des marins.
3. Liste des rôles.
4. Liste des autorisations possibles sur l’application.
5. Gestion des liens disponibles sur la page d’accueil des marins uniquement en transformation.
6. Historique des actions concernant la transformation.
7. Recherche des marins grâce à l’annuaire défense.


<a name="demandes-mindef-connect">
## Demandes Mindef Connect
Lorsqu’un utilisateur inconnu essaye de se connecter la première fois, il reçoit ce message : « Demande enregistrée. Votre compte doit être validé par un administrateur. Veuillez réessayer ultérieurement. ». Cela signifie que tant que l’administrateur n’a pas validé la demande par le biais de ce menu, l’utilisateur n’aura pas accès à l’application.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/demandes-mindef-connect.png' )) }}" width=1000px>

L’administrateur peut refuser d’inscrire le demandeur en cliquant sur le bouton « Refuser cette demande » (2). Si la demande est justifiée, il clique sur « examiner cette demande » (1). 
La fiche utilisateur est alors affichée :

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/edition-utilisateur.png' )) }}" width=1000px>

Certains champs sont pré-remplis mais modifiables. Les autres pourront être complétés plus tard si besoin. 

Dans la partie « Attribuer des rôle »:
(1), sélectionnez le(s) rôle(s) du marin. Enregistrez les données en cliquant sur le bouton (2) "Enregistrer l’utilisateur".
Le bouton « retour » (3) permet de revenir à la liste des demandes d’activation de compte.

<a name="fiches-des-marins">
## Fiches des marins
Vous retrouvez la liste de tous les marins ayant le droit de se connecter à l’application (1) classés par ordre alphabétique. Des filtres (2) (3) vous permettent d’affiner l’affichage. 

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/liste-utilisateurs.png' )) }}" width=1000px>

(4) « Ajouter un marin » pour créer un nouveau compte.
(5) « Modifier » les données du marin.
(6) « Supprimer » le marin. 

** Remarque : ** La suppression ne supprime pas le marin de la BDD mais il n’est plus visible dans les listes. Le compte ne peut plus être créé à nouveau.

(7) « Changer le mot de passe » valable uniquement pour les marins qui n’utilisent pas la connexion Mindef Connect.
(8) « Se faire passer pour » permet de prendre la place du marin sélectionné.


<a name="roles">
## Rôles
À partir de cet écran, vous pouvez gérer les rôles. 

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/liste-roles.png' )) }}" width=600px>

Un rôle regroupe l’ensemble des permissions (ou autorisations ou droits d’accès) qu’aura un utilisateur sur l’application. 

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/attribution-permissions-roles.png' )) }}" width=400px>

<a name="permissions">
## Droits d’accès
À partir de cet écran, vous pouvez gérer les permissions c’est à dire les actions possibles sur l’application.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/liste-permissions.png' )) }}" width=800px>

> {info} Remarques : 
> - Si vous ajoutez une permission, n’oubliez pas de l’associer au rôle qui doit pouvoir effectuer l’action liée.
> - L'association d'une permission à une fonctionnalité du logiciel relève de l'équipe de développement logiciel.


<a name="liens">
## Liens
Cet écran permet de gérer l’affichage des liens liés à la transformation qui apparaissent sur la page d’accueil des marins en transformation.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/liste-liens.png' )) }}" width=800px>

Voici le résultat sur la page d’accueil :

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/accueil-ma-transformation.png' )) }}" width=800px>

<a name="historique">
## Historique
Écran qui liste toutes les actions liées à la transformation.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/liste-historique.png' )) }}" width=1000px>

Des filtres (1) (2)  permettent d’affiner l’affichage. 

<a name="annudef">
## Annudef

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/bandeau-recherche-annudef.png' )) }}" width=1000px>

Cet écran permet de pré-remplir la fiche du marin que vous souhaitez intégrer à l’application avant qu’il n’en fasse la demande par le biais de Mindef Connect.
Saisissez vos critères de recherche (1), puis cliquez sur « Créer la fiche » (2).

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/administration/resultats-recherche-annudef.png' )) }}" width=1000px>
Pour compléter ou modifier la fiche du marin, retournez dans le menu correspondant.

En outre, cette page permet de corriger les données des fiches des utilisateurs pour les aligner avec les données Annudef.

Pour cela:
- rechercher l'utilisateur (ou un groupe d'utilisateurs par exemple en utilisant la recherche par entité).
- aligner les données, soit fiche par fiche, soit en masse grâce aux boutons en tête de liste.


<a name="mails">
## Mails

TODO...