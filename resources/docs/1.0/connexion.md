# Connexion


- [Généralités](#generalite)
- [Login MindefConnect](#login_auto)
- [Login Local](#login_local)
- [Instance de démonstration](#inst_demo)

<a name="generalite">
## Généralités

Pour accéder à FFAST, l’utilisateur doit avoir accès à un ordinateur ayant accès à **Intradef**. Après avoir cliqué sur le bouton "login" de la page d'accueil du site, deux types de connexion sont disponibles :
  - (1) L'authentification MindefConnect (ex-login "auto") qui permet de se connecter avec ses identifiants DR-CPT.
  - (2) Le login "local" qui permet de se connecter avec son @mail et un mot de passe défini par l'utilisateur.
<p>&nbsp;</p>
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/connexion/accueil_login.png' )) }}" >
<p>&nbsp;</p>
<a name="login_auto">
## Authentification MindefConnect

En cliquant sur LOGIN AUTO, si les services du socle DIRISI sont tous fonctionnels, il vous sera proposé  de vous connecter en entrant un identifiant et un mot de passe.
Entrez votre l’identifiant DR-CTP (en général premier lettre du prénom.nom – ex : p.nom) et votre mot de passe : 
  - pour les **marins** à terre (disposant d'une station Intradef normale), il s’agit du mot de passe de la session windows.
  - pour le **bord**, il s’agit du mot de passe associé au compte DR-CPT.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/connexion/MindefConnect.png' )) }}">


Lors de la première connexion, il vous sera demandé de saisir la raison de votre demande d'accès à l'application.L'administrateur validera ensuite l’ouverture des droits. Un mail confirmant votre autorisation d'accès vous sera envoyé dès que votre compte sera actif.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/connexion/msg_1ere_connexion.png' )) }}">

** Remarque :**  Si l’utilisateur ne connait pas son mot de passe DR-CPT, il doit contacter les SIC de proximité pour faire réinitialiser son mot de passe. C’est la procédure à privilégier.
> D’une façon générale, le mot de passe peut-être réinitialisé par le CORSIC de l’unité d’affectation Annudef, en utilisant le site https://portail-motdepasse.intradef.gouv.fr/

<a name="login_local">
## Login Local

Pour pallier le fait que certains marins n'ont pas de session Windows lors de leur mise pour emploi à bord des FREMM ou les indisponibilités des services DIRISI, il est aussi possible de se connecter avec LOGIN LOCAL.

Afin de disposer d'identifiants locaux, vous devez initialiser votre mot de passe local en passant par le menu "GD prénom NOM/changer le mot de passe" lors de votre première connexion MindefConnect. Ce mot de passe doit contenir au moins 8 caractères.
<p>&nbsp;</p>
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/connexion/login_local.png' )) }}" width="300px">
<p>&nbsp;</p>
Dans le cas ou l'authentification MindefConnect n'est pas possible, vous saisissez votre adresse mail intradef complète et le mot de passe choisi (1). Après validation (2), vous pourrez accéder à l'application.

>{info} Que la connexion soit établie avec le login local ou MindefConnect, dans les deux cas, vous travaillerez sur la même application. Il n'y a pas de travail "local" possible.

Si la réinitialisation du mot de passe DR-CPT n’est pas possible ou ne peut pas être faite, et que vous n'avez pas initialisé vos identifiants locaux, il faut l’intervention d’un administrateur de FFAST. Il suffit donc d’envoyer un mail à l’adresse: ffast.notification.tec@intradef.gouv.fr.
D’une façon générale, l’administrateur de FFAST s’efforcera de communiquer un mot de passe temporaire à l’utilisateur et à un cadre de proximité. Il sera alors conseillé à l’utilisateur de modifier son mot de passe à la première connexion.

<a name="inst_demo">
## Instance de démonstration
Une instance permettant de comprendre le fonctionnement de l'application est accessible à tous. Retrouvez les indications de connexion dans la page "Login local".

<a href='https://pprod-ffast.intradef.gouv.fr/demo-ffast'>Accéder à l'instance de démo</a>

** Remarque : ** La base de données est réinitialisée quotidiennement avec quelques données basiques. Toutes les modifications apportées ne seront pas conservées.

