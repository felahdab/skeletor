## 2.1.8a (March 26, 2024)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.8 –> 2.1.8a
- Fixes art #244096: erreur 500 dans le suivi par fonction / liste des marins

## 2.1.8 (March 21, 2024)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.7 –> 2.1.8
- Le composant de Fiche Bilan est désormais Lazy: il se charge uniquement lorsqu'il est affiché. Accélère le chargement du parcours des fiches bilan.
- Ajustement du composant de generation des url de l'aide. Les modules doivent desormais inclure leur nom dans le composant.
- Reorganize documentation and associated images for the migration from larecipe to markserv
- Implements art #210623: intégration de filament dans Skeletor.
- Implement model chat functionnality and associated livewire component.
- Mise à profit de @teleport pour ramener tout le code relatif aux notifications dans le composant Livewire. La Navbar ne fournit plus que l'espace pour afficher le bouton.

## 2.1.7 (December 20, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.6a –> 2.1.7
- Merge commit '69b1107df9b8c6236dc449db8232599ea2216bdd'
- Ajustement de la configuration dusk pour aller chercher les tests Browser dans tous les modules et pas uniquement dans le module Transformation.
- Ajustement composer.json du module Transformation
- Mise à jour composer.json: le projet est désormais fanlab/skeletor
- Merge remote-tracking branch 'origin/master'
- Recuperation des modifications utiles pour intégrer backpack/basset dans Skeletor, sans intégrer backpack/crud pour autant.
- basset configuration publication
- composer require backpack/basset
- composer update depuis le repo packagist.
- Implements art #202019 ajout d'indicateurs dans le tableau bilan par stage
- Implement art #194291 filtres fonction+ type et unité dans le tableau de bord fait par matthieu
- Merge branch 'tuleap-194291-ajout-type-fonction' into sandrine_courant
- Implements art #201893 ajout service maj historique pour valid/annul groupé de stages
- Implements art #197965 rajout filtre pour enlever les Keres speciaux de la chaine de caractere à afficher dans le titre de l'onglet
- Implement art #197943 telechargement fichier ne marchait pas car pas enctype='multipart/form-data' dans le form.
- Merge remote-tracking branch 'origin/master' into sandrine_courant
- Merge branch 'release-2.1.6a' into sandrine_courant
- declaration de propriété en doublon.
- Merge branch 'release-2.1.6a'
- Merge commit '2cfbdd9f35f82c1db36e8bf3189a6b813aebe655'
- fix art #195184: si l'utilisatuer en cours n'est pas affecte a une unite, la restriction de visibilite ne s'applique pas, et ne genere pas d'erreur.
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast
- Si l'unité d'affectation de l'utilisateur n'est pas definie, on ne peut pas appliquer le scope de mise pour emploi.
- Réintroduction filtres Fonction et Unite dans le Dashboard.
- Mise en place du mode='parcomp' dans EtatCompUsers, notamment pour éviter les erreur javascript dans la divvalid.
- Définition section styles dans le layout principal. Utilisation des directives blades @section en lieu et place des sections xml dans la vue du composant EtatCompUsers
- Revert "Merge branch 'enregistrement_excel_fonctions_et_tableau_transf_comp' of ssh://forge.intradef.gouv.fr/ffast/app_ffast"
- Merge branch 'enregistrement_excel_fonctions_et_tableau_transf_comp' of ssh://forge.intradef.gouv.fr/ffast/app_ffast
- fonctionnel
- wip
- modif mineur
- modifs pour avoir le bon chemin d'acces
- lors de la création du module de transfo, un dossier dans storage sera créé
- commande pour créer un dossier de stockage par modules
- Altération de la Factory User pour ne produire que des marins 'pas trop' gradés.
- modifs nom dossier et nom commande
- Commande de nettoyage du dossier tmp
- Ajustement de l'url générée pour pointer sur le fichier Excel généré précédemment.
- sauv, création dos excel regroupant les fonctions, non finit
- Ajustement des wire:model pour conserver le comportement livewire v2
- Merge branch 'master' into tuleap-194291-ajout-type-fonction
- Retrait d'un doublon de use suite à un merge antérieur. Changement des paramètres d'un champs wire.model pour rajouter live, suite à upgrade vers livewire v3.
- Merge branch 'fldb-test-reintegration' into fldb-packages-upgrade
- typfonction_libcourt a coter du nom de fonction
- composer upgrade et artisan dusk:install
- Correction exception dans le job de calcul du taux de transformation.
- Ajustement des tests de login
- Ajustement de classes pour la conformite PSR-4
- Correction test Browser des groupements.
- Adjust test
- Merge remote-tracking branch 'github/master' into fldb-upgrade-livewire-v3
- Implementation d'un test du job de re calcul du taux de transformation.
- Ajustement des sélecteurs CSS des tests Browser suite à la mise à jour livewire v3 et rappasoft v3.
- Merge branch 'master' into fldb-test-reintegration
- Report des dépendances js du Dashboard du module transformation dans le composant.
- Ajustement du wire:model du composant des preferences utilisateur du module Transformation. Correction de la directive assets du composant fullcalendar.
- Correction d'un bug de route dans une vue, et retrait des directives livewire du layout principal.
- WIP ajustement des composants. Correction des méthodes générant des évènements (emit, dispatch, etc.)
- Re-enable injection of core and third party assets. Remove Alpine.js from main layout (since it is injected by livewire v3)
- WIP: first test at livewire v3 asset loading for a component. Problem with Alpine starting x-init before the asset are fully loaded.
- Modify the way we search for modules user preferences components.
- Adjust livewire components namespace. Remove unused UserList component.
- Adjust TrustProxies middleware settings to allow file uploads. Implement custom SupportFileUploads feature provider to setup custom routes.
- Further modifications to make the livewire prefix a configuration parameter.
- WIP-at this stage livewire v3 works. Still have to figure out a way to control the route publishing feature without altering livewire code.
- Save previous livewire configuration. Publish livewire v3 configuration.
- Reactivate auto discovery of livewire/livewire Deactivate PrefixesLivewireServiceProvider
- livewire, rappasoft and asantibanez upgrade. Correction of render method signature in datatables components. livewire:upgrade not executed.
- Report des dépendances js du Dashboard du module transformation dans le composant.
- Ajustement du wire:model du composant des preferences utilisateur du module Transformation. Correction de la directive assets du composant fullcalendar.
- Correction d'un bug de route dans une vue, et retrait des directives livewire du layout principal.
- WIP ajustement des composants. Correction des méthodes générant des évènements (emit, dispatch, etc.)
- Re-enable injection of core and third party assets. Remove Alpine.js from main layout (since it is injected by livewire v3)
- WIP: first test at livewire v3 asset loading for a component. Problem with Alpine starting x-init before the asset are fully loaded.
- Modify the way we search for modules user preferences components.
- Adjust livewire components namespace. Remove unused UserList component.
- Adjust TrustProxies middleware settings to allow file uploads. Implement custom SupportFileUploads feature provider to setup custom routes.
- Further modifications to make the livewire prefix a configuration parameter.
- WIP-at this stage livewire v3 works. Still have to figure out a way to control the route publishing feature without altering livewire code.
- Save previous livewire configuration. Publish livewire v3 configuration.
- Reactivate auto discovery of livewire/livewire Deactivate PrefixesLivewireServiceProvider
- livewire, rappasoft and asantibanez upgrade. Correction of render method signature in datatables components. livewire:upgrade not executed.

## 2.1.6a (November 24, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.6 –> 2.1.6a
- Restaure les propriétés colls_sous_objs et colls_sous_objs_non_orphelins dans User. TODO: voir si on peut les déplacer dans Modules\Transformation\Entities\User

## 2.1.6 (November 23, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.5a –> 2.1.6
- Implements art #139971 outil d'analyse de l'utilisation de l'application
- Implements art #187520 suite des modifs scope memeUnite
- Implements art #187520 unité actuelle mise par défaut
- Implements art #187520 suite des modifs scope memeUnite
- Poursuite du retrait des dépendances à laravelcollective/html
- Ajustement des tests du module Transformation au déplacement des fonctions de suivi de la transformation vers l'entité User du module Transformation. Retrait de propriétés orphelines du modèle App\Models\User.
- evolution doc connexion
- Implements art #187520 mise en place du scope meme unite sur les model/users
- Implements art #189991: fonction de reset de mot de passe
- Implements password reset logic and tests.
- Rajout des fichiers de langue FR
- ajout de la barre de recherche et des images
- filtre des marin sur le tableau
- Ajustement de la configuration du backup pour surveiller les mêmes backups que ceux qui sont créés. Fixes art #176059
- deplacement des fonctions propres à la transfo de model/user dans entity/user
- composer remove laravelcollective/html
- Mise à jour composer.lock. auditing publish.
- composer require laravel-shift/blueprint
- laravel-blueprint install

## 2.1.5a (October 17, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.5 –> 2.1.5a
- Merge commit 'dc3c8c106caeae02d0b99efa3a60e97895184c67'
- Implement art #180650  la route était fausse suite aux modifs ( Implments art #176965 ) form:: en x-form
- Ajout du repository du module de programmation d'activite au composer.json de Skeletor.
- Ajout .gitignore dans le dossier Module pour ne tenir compte que des modules de base.
- Mise à jour CLassLoader.php
- Merge branch 'fldb-install-blueprint'
- composer require laravel-shift/blueprint
- Implements art #178901 users soft deleted pris en compte dans les calculs et ajout d'un filtre associé

## 2.1.5 (October 10, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.4 –> 2.1.5
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast
- changement menu tansfo en deux parties : gestion et suivi
- Implements art #177832 ajouts filtres dans statparservice.
- changement libelles MPE-> Partage de dossier
- Mise ajour reference laravel
- changement du firstorcreate car recreait systematiquement un enregistrement dans table paramaccueil
- Merge remote-tracking branch 'origin/sandrine_courant' into sandrine_courant
- Implements art #176965 changement de {!form:: en <x-form::
- Mise à jour composer.
- Merge remote-tracking branch 'origin/sandrine_courant' into sandrine_courant
- WIP
- Merge remote-tracking branch 'origin/sandrine_courant' into sandrine_courant
- Modif pour qu'il n'y ait plus de message d'erreur si pas de tache selectionnée
- Correction bug : affichage monlivret impossible car pb entre entity/user et Model/user
- Suppression du fichier modules_statuses.json de l'index.
- Remove modules_status.json from tracked files: this file depends on each instance deployment.
- Ajustement composer.json pour pointer sur le repo du carnet de sante
- Ajustement des use et de l'url de gestion des groupements
- Merge remote-tracking branch 'internet/release-2.1.4' into sandrine_courant
- Ajustement du builder de la table des mises en visibilite pour ne pas voir apparaitre les utilisateurs soft deletes.
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast
- Modifications de Skeletor isolées
- Merge remote-tracking branch 'origin/sandrine_courant' into sandrine_courant
- Premiere implémentation du planning des mises pour emploi.
- Implement art #176531 suppression definive possible
- Correction de bug lié à la transition vers Entities\User.
- Merge branch 'fldb-integrate-fullcalendar' into sandrine_courant
- Merge remote-tracking branch 'origin/master' into fldb-integrate-fullcalendar
- Conversion to livewire component.
- Merge branch 'fldb-package-update' into tuleap-176386-mise-a-jour-des-packages-logiciels
- Reinstall chrome driver. Update ClassLoader with composer update.
- composer update - tests ok
- suite mise en visibilite ajout champ "sansdates" et modif routes pour debug show/planning.
- Initial fullcalendar integration trial
- oubli
- suite mises en disponibilite partie planning. En attente du plugin gestion de calendrier.
- Merge branch 'tuleap-162500-mpe-changement-d-unite' into sandrine_courant
- suite des mises en visibilité create store edit update destroy
- 1ere partie visu des mises en visibilité
- Merge branch 'tuleap-162500-mpe-changement-d-unite' of ssh://forge.intradef.gouv.fr/ffast/app_ffast into tuleap-162500-mpe-changement-d-unite
- modification pour qu'un enreg soit créé dans table paramaccueil si elle est vide
- WIP
- WIP
- Merge branch 'tuleap-162500-mpe-changement-d-unite' into sandrine_courant
- Merge branch 'tuleap-162500-mpe-changement-d-unite' of ssh://forge.intradef.gouv.fr/ffast/app_ffast into tuleap-162500-mpe-changement-d-unite
- WIP
- Premiere implementation: Création d'un middleware destine a limiter la visibilite des objets de type User. Inscription de ce middleware aux middleware persistents de Livewire. Rajout de ce middleware aux routes du module Transformation.
- ajout d'indicateurs supplémentaires sur le dashboard et le dashboard archive
- afichage champ commentaire dans liste des demandes MC
- WIP

## 2.1.4 (septembre 18, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.3 –> 2.1.4
- Revert "Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.3 –> 2.1.4"
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.3 –> 2.1.4
- pour faciliter un tri dans l'archivage sur la date debarq
- Implements art #159168 ajout filtre et colonne Unite actuelle dans stattuteur et userstable
- Phrase explicative changée.
- suite correction bug affichage page préférences : verif existence pageaccueilpossible
- correction bug affichage page préférences : verif existence pageaccueilpossible
- Image et texte page accueil de l'instance désormais modifiables
- modif filtre udest
- Unite est un modele skeletor pas une entite du module transfo
- Retrait __call en double apres merge
- Merge branch 'master' into sandrine_courant
- Implements art #159647 art # 159652 augmentation de la taille des champs des filtres brevet et secteur
- Modification du scope pour prevoir explicitement le cas du superAdmin.
- Implements art #159168: permettre de limiter la visibilité des utilisateurs en transformation en fonction de leur unite d'affectation.
- sauvegarde comentaire proposé lors de la validation
- Ajustement des vues et des requetes pour réintégrer la possibilité de définir l'unité d'affectation actuelle.
- Workaround du bug Glorand/laravel-model-settings et ajustement des relations pour utiliser le modele Personne.
- Création d'un modèle Personne dans le module Transformation pour recueillir les contraintes spécifiques du module à appliquer
- Merge remote-tracking branch 'origin/tuleap-159168-permettre-de-limiter-la-visibilite-des-utilisateurs-en-fonction-de-l-unite-d-affectation' into sandrine_courant
- Merge remote-tracking branch 'origin/tuleap-159168-permettre-de-limiter-la-visibilite-des-utilisateurs-en-fonction-de-l-unite-d-affectation' into tuleap-159168-permettre-de-limiter-la-visibilite-des-utilisateurs-en-fonction-de-l-unite-d-affectation
- Ajustement des relations des modèles Fonction, SousObjectif et Stage pour utiliser le modèle Personne du module plutôt que le modèle User général.
- Creation du modele Personne dans le module Transformation. Application du scope permettant de limiter la visibilité des marins en fonction des autorisations.
- Workaround bug lors de l'extension du modèle User par un autre modèle.
- Création du module RH. Fusion des migrations dans une migration unique.
- Merge branch 'tuleap-159168-permettre-de-limiter-la-visibilite-des-utilisateurs-en-fonction-de-l-unite-d-affectation' into sandrine_courant
- sauvegarde comentaire proposé lors de la validation
- Application du scope MemeUnite dans les tables du module Transformation.
- Création d'un scope qui restreint les requetes pour faire correspondre le champs unite_id du modele requete avec le unite_id de l'utilisateur a l'origine de la requete, sauf pour les utilisateurs disposant de la permission transformation::view_all_users
- Modification de Skeletor: la macro "scoped" permet d'appliquer un scope global (défini dans une classe à part) à un modèle à la demande.
- Migration pour créer une nouvelle permission

## 2.1.3 (août 29, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.2b –> 2.1.3
- Merge commit '61348668950d92c6b9bcc21c707c31440e378f4d'
- modif libelle mail de la page login
- Mise en cache des informations MindefConnect de l'utilisateur lorsque celui-ci se connecte via MindefConnect.
- Merge remote-tracking branch 'origin/master' into sandrine_courant
- Probleme d'affichage des sous objectifs réglé
- Implements art #158472: decouvre les composants livewire de gestion des preferences de l'utilisateur de façon fiable.
- correction
- Implements art #158283 ajout d'une page par défaut dans le menu preferences pour que les marins en transfo puissent aussi choisir.
- Implements art #158283 filtre secteur et service modifié

## 2.1.2b (August 23, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.2a –> 2.1.2b
- Implements art #150052 #148134 affichage parcours fiche bilan retabli car il manquait le mode en parametre

## 2.1.2a (July 20, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.2 –> 2.1.2a
- Correction: les pages d'accueil possibles ne s'affichent pas si on n'est pas super admin.

## 2.1.2 (July 19, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.1 –> 2.1.2
- Merge remote-tracking branch 'origin/master' into sandrine_courant
- Renvoi du choix de la page d'accueil à un composant de Skeletor. Les modules peuvent préciser les pages qu'ils offrent dans leur configuration. La page de préférences de l'utilisateur peut inclure les composants de chaque module.
- Merge commit '9dd28dc76762bd87fe27aa6d75ef64095015a213'
- suite modif erreur route homeindex
- Merge commit '13e0d883496827bc572f49404ea2dab7757ad7ac'
- erreur de route homeindex dans les preferences
- Mise en place préférence pour choisir sa page d'accueil après connexion.
- suite ajout croix pour fermer messages de validation/erreur
- Implements art #112127 suite role superadmin avec ecran mindefconnect
- Implement art #112127 création du role superadmin avc booleen dans table user
- ajout croix pour fermer messages de validation/erreur
- Ajout de controle dans le seeder des permissions.
- Implements art #140071 creation route specifique pour impression monlivret et mafichebilan
- composer require stancl/tenancy
- Mise à jour des .env pour configurer redis et utiliser redis comme moteur de cache par defaut
- Publication configuration de spatie/larevel-permission. Désactivation du cache pour ce package.
- Configuration REDIS
- Implements art #117497 remplacement des retours chariot par " *".
- Implements art #141362 le popover se ferme automatiquement quand on clique ailleurs sur la page.
- composer require predis/predis

## 2.1.1 (July 10, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.1.0 –> 2.1.1
- Implements art # 117946 evolution affichage suivi par compagnonnage
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast into sandrine_courant
- Modifie la commande de backup quotidienne pour inclure les fichiers configures.
- Restreint le backup aux livrets archivés.
- Modifie la regle de nommage des backups pour inclure le prefixe et l'environnement de l'instance.
- Schedule backup clean et backup run une fois par jour.
- Ajustement du script de génération des .env
- Publication des configurations de laravel-backup et de backup:restore
- correction filtres %like% -> like% sinon elec -> telecom
- oubli
- Merge remote-tracking branch 'origin/master'
- Correction fichiers CHANGELOG et VERSION qui contiennent des traces d'un conflit de merge non résolu.
- Suite modularisation de la transfo, évolution de homeindex pour prise en compte du module::homeindex
- composer update & composer require spatie/laravel-backup && composer require wnx/laravel-backup-restore
- Merge branch 'master' into sandrine_courant
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.0.1 –> 2.1

## 2.1.0 (July 06, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.0.1 –> 2.1.0
- Activation de la page des préférences personnelles par attribution de la permission mespreferences au role user.
- Rajoute une vérification de la permission transformation::notifications.lache_fonction pour choisir les utilisateurs destinataires des notifications de lâcher.
- Simplifie le panneau des préférences utilisateurs pour ne faire apparaitre que les fonctions.
- On cree la permission transformation::notifications.lache_fonction pour pouvoir régler qui peut recevoir les notifications de lacher
- Ajustement des tests des pages de gestion des Fonction. Création des tests des pages de gestion des Compagnonnages.
- Implements art #117949 modif fiche bilan pour prise en compte date fin validité des stages
- Implements art #137836 : corrige le bug consécutif à la modularisation de FFAST empechant de rajouter un stage à une Fonction.
- Ajout possibilite impression PDF de la fiche bilan
- Implements art #67140: Envoie une notification aux utilisateurs lors d'un lache dans une fonction, en tenant compte des préférences de chaque utilisateur.
- Complément de documentation DEV.
- Implements art #117493 permission transfo.validerlacheroudouble mise en fonction. Attention, cette permission n'est pas liée à une route.
- Implements art #97452 evolution des affichages pour prise en compte de la date embarquement dans le recap par service + ajout filtre datemb.
- Implements art #127531: découplage de Skeletor et du module Transformation sur la restauration des utilisateurs précédemment supprimés

## 2.0.1 (June 28, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 2.0.0 –> 2.0.1
- Implements art #118754 : Modification des routes et permissions pour les préfixer avec transformation::. Modification de l'affichage dans la page d'édition des rôles pour regrouper les permissions par module.
- Implements art# 118917 : Retrait du package recca0120/terminal inutile.
- Ajoute l'affichage de la version des modules activés dans la NAVBAR
- Retrait du lien vers la liste des permissions (droits d'accès) de la Navbar: il n'y a aucun cas où on veut qu'un utilisateur, même administrateur, y ait accès.

## 2.0.0 (June 22, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.6 –> 2.0.0
- Implements art# 117991 conversion de FFAST en module de Skeletor
- Implement art #117495 correction pour afficher les sous objectifs dans l'ordre enregistre pour objectif.show et dans le livret
- Nouvelle présentation pour les logins. Ajout message explicatif a cote des types de connexion
- Ajustement de la configuration dusk générale pour inclure les tests des modules
- Creation .gitignore dans public pour nettoyer la staging area et faciliter la revue des changements survenus
- Reconfiguration de l5-swagger pour explorer les modules
- composer require nwidart/laravel-modules
- composer update

## 1.2.6 (June 14, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.5 –> 1.2.6
- Mise à jour de la documentation
- Implements art #114179 amelioration de la gestion des draghandle
- Implements art #61731 correction affichage noms valideurs dans entete-fonction du livret car les caracteres speciaux n'etaient pas affiches correctement
- Implements art #74326 un seul écran pour le login avec les deux choix local/auto + ajout commentaire à saisir si 1ere connexion
- Implements art #71666 suppression des liens feuille de style et jsfile ds menu general
- Implements art #72242 Implements art #112134 remise en forme suite ajout de l'ordre d'affichage Implements art #71666 suppression des refs à feuille de style personnalisée et jsfile personnalisé
- Implements art #72238 changement affichage des title en popover et tooltip
- Implements art #113576 modification de la couleur d'affichage des dates de validation pour les les dates > à la date du jour.
- Implements art #113146 Contourne le bug résultant dans le non affichage du suivi par compagnonnage pour certains compagnonnages.
- art #113146 resolution du fullmemory en supprimant le recalcul du taux par comp par un affichage du nb ssobjvalidés / ssobfàfaire
- Implements art #112134 Permet de définir l'ordre d'affichage des éléments du parcours de transformation depuis les pages d'édition.
- Ajustement des seeders pour prendre en compte la permission transformation.updatelivret (non liée à une route).
- prise en compte de la permission transformation.updatelivret pour controler la possibilite de valider les elements du parcours de transfo.
- Implements art #112136: Dans le suivi par fonction, prendre en compte la permission fonction.validermarins Implements art #112132: Ajout d'un champ url pour les Stage et les SousObjectifs + affichage dans le livret de transformation le cas échéant Implements art #112130: Ajout filtre "Unité destination" dans les tables d'utilisateurs. Implements art #102007: Corrige le calcul du numbre de jour de présence dans le bilan par service. Implements art #72234: Corrige le décalage des boutons du livret de transformation lors de l'ouverture du modal Bootstrap
- Implements art #101997 Corriger test dusk suivi de la transformation par compagnonage
- Implements art #112131 Rajout de la possibilité de supprimer un mail antérieur

## 1.2.5 (May 22, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.4b –> 1.2.5
- Ajoute la correction du champs created_at au seeder de correction du parcours.
- Merge branch 'tuleap-62052'
- ajout onglet liste des fonctions avec leurs comps et stages
- Merge branch 'master' into tuleap-62052
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast
- inutile mais besoin pour pouvoir pulller master
- modif seeders pour éviter les dates à null dans created et updated
- retouche des affichages
- Re-conversion de users.create pour utiliser les composants Tomsix.
- Nettoyage du panneau d'aide Annudef de création d'utilisateur
- Les boutons de double et de lacher n'avaient pas ete convertis pour utiliser le modal bootstrap...
- Rajout de quelques fichiers à ignorer pour git.
- Merge branch 'tuleap-62052'
- ajout filtre lache/nonlache dans le suivi par fonction a quai
- Suppression du controlleur et des vues de test. Tout ceci n'a rien à faire dans master.
- Retrait des routes de test.
- Petite remise en forme du javascript dans users.create
- Changement de méthode d'appel de SimpleXMLElement dans AnnudefController pour tenir compte de la deprecation.
- Simplification de la partie javascript de la page users.create
- debug : le bouton ajouter et attribuer fonction dans le create user ne fonctionnait pas
- Merge remote-tracking branch 'internet/master'
- resolution du conflit de merge master
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast
- Modification des références aux routes pour utiliser le controlleur de la Transformation.
- Création des methode et vue pour le suivi par compagnonnage dans la transformation.
- Creation d'un test Dusk elementaire pour les pages de suivi de la transfo.
- Correction vue users.create
- Merge branch 'tuleap-71454-ajouter-un-utilisateur-faire-la-recherche-annudef'
- Adjust javascript alignment
- Inscription du nouveau seeder pour les nouvelles instances.
- Creation d'un seeder pour corriger les champs updated_at null.
- Correction du lien vers la documentation pour la page de statistiques par compagnonage.
- Merge remote-tracking branch 'intradef/tuleap-62052' into test-notifications
- Merge remote-tracking branch 'intradef/simplification-composants-blade' into test-notifications
- Use new bootstrap-icon component to display a bell icon in the notification button.
- Rename public property of bootstrap-icon component.
- Creation d'un composant Blade permettant d'utiliser simplement les icones Bootstrap.
- Renommage du modele de notification de base.
- Install twbs/bootstrap-icons package
- Utilisation de la nouvelle vue Blade pour inclure les notifications dans le layout général.
- Creation d'une view Blade pour le panneau des nofications.
- Adaptation du toaster au nouveau format des notifications.
- Francisation. Une notification comporte un titre, une mention et un texte.
- Modification du panneau des notifications pour utiliser les NotificationToaster. Création d'un evenement javascript pour fermer toutes les notifications.
- Création d'un notification toaster qui affiche une notification.
- Activation du backdrop sur le panneau des notifications
- Renommage des notifications
- Association de l'evenement au listener pour les proposition de validation.
- Creation du Listener lorsqu'une proposition de validation arrive.
- Creation de l'evenement devant signaaler une proposition de validation.
- La panneau des notifications affiche les notifications sous forme de toaster. Lorque l'on ferme une notification, celle-ci est marquée comme lue en base.
- Premiers essais de notification
- Create migration for notifications table.
- Retrait du nettoyage du cache des permissions depuis le seeder.
- Merge branch 'master' into simplification-composants-blade
- Insertion du Chrome Driver pour dusk
- modif pour que export parcours soit accessible au role etatmajor
- correction affichage pour validation multiple par fonction : la checkbox pour les sous objectifs est de nouveau accessible
- ajout lien vers livret de transfo pour chaque marin
- menu preference rendu accessible
- fin des modifs pour date_validite d'u stage
- Retrait d'un ddd orphelin.
- Modification pour ignorer les certificats SSL invalides de Mindef Connect.
- bilan global : retrait de l'infobulle (liste marins ayant cette fonction)
- suite modif doc
- suite des modifs de la doc
- oubli pour modif ecran stat2ps
- suite mise a jour de la doc
- evolution ecran stat2ps pour prise en compte date validite dans calcul du nb de marins a valider
- correction pour date validite nulle et amélioration affichage
- ajout d'une date validité pour les stages
- evolution de la doc en cours
- Insertion du Chrome Driver pour Dusk.
- Ajout de la non verification SSL pour les recherches Annudef.
- Merge remote-tracking branch 'origin/packages_upgrade' into essais_de_mise_en_forme_automatique_et_javascript
- Merge branch 'master' into essais_de_mise_en_forme_automatique_et_javascript
- Update TestController call method in routes file.
- Merge branch 'packages_upgrade'
- Merge branch 'master' into packages_upgrade
- Upgrade all packages.
- Merge branch 'master' into essai-composants-blade-tomsix
- Merge branch 'master' into essai_frappe_gantt
- Insertion des classes PHP canoniques pour faciliter le parcours des sources depuis VS Code.
- Remise en forme automatique pour essai
- Remise en forme automatique pour essai
- Remise en forme automatique pour essai.
- Remise en forme automatique pour essai
- Construction de la liste des sous objectifs du compagnonage d'un coup plutot que de facon iterative
- Utilisation des méthodes précédentes pour diminuer le nombre de requetes.
- Mise en cache des taches, objectifs et sous objectifs d'un compagnonnage.
- Introduction d'une méthode permettant de connaitre l'état de validation d'une liste de sous objectifs dans le modele User.
- Recours au eager loading pour diminuer le nombre de requetes nécessaires au chargement des donnees du parcours de transformation.
- Mise en cache de la collection des sous objectifs d'une fonction, et du nombre d'objectifs a valider, pour essayer d'améliorer les performances.
- Modification de la methode d'acces aux sous objectifs d'un Objectif pour reutiliser les donnees deja chargees s'il y en a.
- Changement de methode d'appel aux objectifs d'une tache pour reutiliser les donnees deja chargees s'il y en a.
- Mise en cache de la collection des sous objectifs d'un compagnonnage.
- Essai de composant blade.
- suivi  par comp change de menu
- amelioration affichage tranfo par comp
- suite ajout suivi transfo par compagnonnage
- je refais
- obligé pour tenter le merge master
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast
- ne me parait pas necessaire
- ajout d'un tableau permettant d'afficher l'etat transfo pour tous les marins d'un compagonnage
- changement affichage pour enlever fond gris
- Conversion de users.create aux composants tomsix.
- Suppression d'espaces superflus
- Conversion de users.edit vers les controles tomsix.
- Test des composant tomsix
- Installation de tomsix/laravel-components-library et publication de la configuration
- Suppression de l'ancier x-documentation-link
- Remplacement du composant x-documentation-link par le nouveau x-help-link
- Creation du lien vers la doc sous forme de composant Blade anonyme
- Modification affichage taux de transformation.
- Merge branch 'master' into tuleap-72206-faire-en-sorte-que-les-tests-n-envoient-pas-de-veritable-mail
- Interdiction d'envoyer des mails lorsque l'environnement n'est pas production.
- Améliorations du design de la page de préférences.
- Oubli
- Retire le fond bg-light de toutes les pages ou presque.
- Rajout des badges des roles détenus dans la barre de navigation.
- Ajout d'un test jspreadsheet-ce
- Mise en place d'un test pour GANTT
- Download of javascript libraries and dependencies
- Merge branch 'master' into tuleap-72285-ameliorer-la-generation-d-utilisateurs-factices
- Passage à un déclenchement quotidien
- Choisit aléatoirement le secteur, la spe, le grade et le diplome des utilisateurs factice parmi les elements en base (évite de crééer des faux éléments pour celà)

## 1.2.4b (April 28, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.4a –> 1.2.4b
- Rajoute le filtre par role a la table de selection des utilisateurs pour les mails

## 1.2.4a (April 28, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.4 –> 1.2.4a
- Changement de forme page recherche Annudef.
- Reactivation de la feuille de style CSS.
- Remet en place les bordures de tables dans le livret.
- Remet en place les 2 colones

## 1.2.4 (April 28, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.3 –> 1.2.4
- Merge branch 'master' into tuleap-62052
- Gere le conflit de merge
- Merge branch 'master' into tuleap-71454-ajouter-un-utilisateur-faire-la-recherche-annudef
- Ajustement de l'affichage du bandeau de recherche Annudef pour la création de nouveaux utilisateurs.
- Modification de l'ordre d'inclusion des librairies Javascript.
- Desactivation du CSS custom.
- Alpinisation du javacsript de la page Statistiques.
- Suppression code inutile.
- Ajustement du mode de la table de selection des destinataires des mails.
- Modernisation de la forme de la page de recherche Annudef.
- Corrections de forme dans les listes d'Objectif, Stages, Taches.
- Correction de forme liste des compagnonages.
- Correction de forme liste des fonctions
- Utilisation Bootstrap pour colones du bilan global
- Utilisation Bootstrap pour les colones du bilan des stages
- Ajustement de forme dans la situation des marins pour un stage
- Conversion des divvalid et divvalidcomment en modal dans la validation des stages
- Ajustement de forme sur les formulaire de gestion des Taches
- Ajustement de forme sur les formulaire de gestion des Objectifs
- Ajustement de forme sur le MailEditComponent
- Mise à jour de tous les tests pour maximiser la fenetre du browser et tenir compte de la modification de la div bugreport.
- Interversion de l'ordre de chargement des librairies javascript.
- Changement de la classe dans le modal bugreport.
- Modification des boutons du livret pour activer les nouveaux dialogues modaux
- Conversion des divvalid du livret de transformation en modal bootstrap.
- Conversion divvalid en modal bootstrap pour la validation des stages.
- Modification du bouton Signaler un problème pour activer le model de bugreport.
- Convertion de la div de bugreport en model bootstrap standard.
- 2eme essai : la proposition de validation d'une tache avec un ssobj deja valide remplissait la date proposition.
- Merge branch 'tuleap-62052' of ssh://forge.intradef.gouv.fr/ffast/app_ffast into tuleap-62052
- correction bug : la proposition de validation d'une tache avec un ssobj deja valide remplissait la date proposition.
- Ajustement de l'utilisateur créé pour être dans les conditions de succes du test.
- Ajout filtre par secteur et colonne taux de transformation à la table des utilisateurs pour le parcours des fiches bilan.
- Particularisation de la vue du taux de transformation par fonction.
- Active la nouvelle présentation du taux de transformation
- Remplace le taux de transfo brut par un texte colore comme il faut.
- Merge commit '58187b54236a93d98135b0001c434836349e105a'
- Retrait d'un dd orphelin..
- Ajuste l'asciisation des grades
- arrondi des chiffres affichés
- decode les chaines htmlspecialchar encodees.
- htmlspecialchars des informations de Annudef pour éviter les apostrophes notamment.
- suppression ligne inutile
- Merge branch 'master' into tuleap-62052
- acces dashboard possible et creation dashboardarchive .
- Simplification des event pour la fermeture du panneau Annudef
- Prendre le prenom usuel et non tous les prenoms
- BUGFIX + collapse aide on click
- Implemente une aide Annudef dans la creation d'utilisateur.
- Rajout des boutons vers les éléments individuels de suivi de la transfo au parcours des fiches bilan.
- Rajoute d'un filtre par fonction à StattuteurTable
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast into tuleap-62052
- nouvelle table archive qui va remplacer la table statistique, modid des pgms pour prise en compte.
- BUGFIX: la table des utilisateurs ne tenait pas compte des modification sur les fonctions à quai.
- Passe la selection des destinataires en mode usertable dashboard.
- Rajoute les fonctions mer à l'entete de la fiche bilan.
- Retire la contrainte d'unicité de la fonction a quai
- Cree une tache pour corriger les display_name des utilisateurs. Planifie cette tache toutes les 5 minutes.
- Rajoute un filtre sur les roles détenus dans la UsersTable. Ce filtre permet de sélectionner les utilisateurs affichés en fonction des rôles détenus.
- creation nouvelle table archives
- correction fote d'orthographe

## 1.2.3 (avril 14, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.2 –> 1.2.3
- Report le calcul des utilisateurs pertinents dans la methode mount de la SushiUserTable pour diminuer le nombre de requete lors des changements de filtre et d'ordre.
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast into tuleap-68233-convertir-les-tableaux-de-bilan-par-fonction-avec-sushi-pour-permettre-les-tris-et-autres-fonctions
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast into tuleap-62052
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast into tuleap-68233-convertir-les-tableaux-de-bilan-par-fonction-avec-sushi-pour-permettre-les-tris-et-autres-fonctions
- Cree le PrefixedLivewireServiceProvider. Retire livewire/livewire des package autoloades. Inscrit le nouveau ServiceProvider aux providers a charger par Laravel. Rajouter la prefixe de route au fichier de configuration de Livewire.
- Simplification du SushiUser.
- Modification pour gerer les cas de marins dont les informations ne sont pas toutes renseignees.
- 3eme changement de longueur de champ lib sous objectif
-  modif: 2 demandes de proposition de validation du meme objectif validait l'objectif
- Change le composant livewire utilise pour afficher les liste de marins par fonction.
- Cree le SushiUser pour disposer des donnees pour les tableaux de suivi des fonctions.
- maj livret pour prise en compte du role visiteur et htmlspecialchr pour le nom du valideur
- Merge branch 'master' into tuleap-62052
- ajout restriction pour que bouton retirer stage ne s'affiche que quand permission attribuerstage est ok
- ajout capture ecran mindefconnect dans la doc
- correction saisie longueur libssobj en 1000
- correction longueur libssobj en 1000
- modification de la longueur de 500 à 750 pour le sous objectif
- ajout bouton retour haut de page sur le livret transfo

## 1.2.2 (avril 06, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.1 –> 1.2.2
- Disable user preferences. Allow bump-version execution by owner.
- Merge branch 'master' into tuleap-66980-implementer-une-solution-des-preferences-utilisateur
- Ajuste le composant de gestion des preferences utilisateur pour eviter que l'accordeon se referme tout seul quand l'utilisateur change un parametre
- Ajustement de l'affichage des fonctions.

## 1.2.1 (April 06, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.2.0 –> 1.2.1
- Ajuste le livret de transformation multiple pour permettre un test dusk elementaire. Implemente un test dusk elementaire sur le livret de transformation multiple.
- Merge branch 'tuleap-67148' into tuleap-67148-remettre-en-fonction-de-livret-de-transformation-multiple
- Correction du livret de transformation pour permettre les validations collectives.
- Pour le mode multiple, il n'y a pas de user passe en parametre.
- Implemente un composant permettant de regler les preferences utilisateur. Declare la route y conduisant. Rajoute l'entree dans la NAVBAR.
- Correction des settings par defaut pour FFAST.
- Attribue des settings au modele User. Definit les premiers settings par default pour l'application FFAST.
- Migration pour creer la table des settings.
- composer require glorand/laravel-model-settings
- Update packages
- Composer require calebporzio/sushi

## 1.2.0 (mars 30, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.1.5b –> 1.2.0
- Desactive l'envoi de mail dans les tests browser du module d'archivage.
- Merge branch 'master' into tuleap-62052
- Envoi un mail lorsque le compte d'une utilisateur est reactive.
- oubli
- ajout/modif doc pour mot de passe local
- Modification du test du controlleur User pour eviter l'envoi de mails intempestifs lors des tests.
- Un mail de bienvenue sera envoye lor de la creation d'un utilisateur en direct, par une recherche Annudef, ou par une demande Mindef Connect validee.
- Ajustement du lien vers la documentation de connexion.
- Ajustement de la configuration Larecipe pour que l'utilisateur arrive par defaut sur les generalites.
- Creation du mail de bienvenue.
- oubli de rechanger != en == pour test
- evolution doc : page accueil, nouvelle navbar, parcours fiches bilan, recalcul transfo
- evolution de la navbar pour uniformisation
- changement du nombre de lignes a l'affichage car le bouton annuler ne fonctionne pas directement sans F5 sur les autres pages que la premiere dans la table livewire
- amelioration de l'affichage pour gestion des stages par 2ps (permission attribuer stage)
- dernieres corrections
- ajout du recalcul en arriere plan des tx de transfo des modification d'un morceau de parcours
- gestion des noms d'onglets excel avec des accents
- modification pour associer tous les users à un nouveau stage lors de l'ajoutd'un stage à une fonction
- Re installe le driver chrome pour dusk suite a la mise a jour du framework.
- Change la definition des routes des API pour eviter les conflits avec les routes standard
- Retire un test inutile.
- Implemente un middleware pour forcer l'entete accept a application/json. Gere la priorite des middleware pour s'assurer que ce middleware est execute avant celui de l'autorisation. Tout ceci afin que les appels aux api non authentifies recoivent un message d'erreur en json et ne soient pas rediriges vers la page d'accueil de l'instance. Simplifie en outre les routes web pour retirer la redirection vers / lorsqu'un utilisateur authentifie demande la page de login.
- Cree un espace Api pour recueillir les controleurs. Documente le mecanisme de securite pour toutes les API. Cree la resource User pour faciliter la conversion des User vers le Json.
- Ajoute une migration pour ajuster la table des tokens.
- Corrige Livewire pour ajouter le prefixe aux routes. Configure l5-swagger pour adapter la génération des documentations de l'API aux specificites des deploiements FANLAB.
- Publish l5-swagger config and view
- Upgraded laravel to v10.
- composer update
- Install L5 swagger from DarkaOnLine to document API
- Add sanctum middleware to api group.
- Retire la reference au champs photo.
- Retire le code relatif a l'upload de la photo du controlleur des Utilisateurs.
- Retire le champs photo des pages de creation et d'edition des utilisateurs.
- Ajoute la possibilite d'arreter le recalcul des elements de la transformation en cours de route.
- Desactive le polling lors les jobs ont tous ete traites.
- Cree la table cache en base de donnees. Modifier la configuration du cache pour utiliser la base. Programme une tache recurrent pour nettoyer la liste des jobs toutes les heures.
- Ajoute la migration pour creer la table job_batches
- Merge branch 'master' into tuleap-63825-configurer-le-moteur-d-execution-des-jobs-d-arriere-plan
- Deplacement des calculs dans le service RecalculerTransformationService. Ajustement des composants Blade ffast-pprogression. Creation composant Livewire GererRecalcul.
- Changement de l'adresse de bcc des mails envoyes depuis FFAST.
- Convertit le calcul du nb de jours de validation en job d'arriere plan. Ajuste l'envoi des mails egalement.
- Switch queue driver to database.

## 1.1.5b (mars 20, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.1.5a –> 1.1.5b
- Bugfix: tient compte du fait que l'unite identifiee peut etre nulle s'il n'y a pas de concordance.

## 1.1.5a (mars 17, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.1.5 –> 1.1.5a
- Corrige un bug dans ffast:recaculetransformation

## 1.1.5 (mars 17, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.1.4 –> 1.1.5
- Merge branch 'master' into tuleap-62052
- mise a jour pour afficher dans livret et page stat par service une icone enveloppe si il y a des demandes en attente de validation.
- Retire une copie de vue inutile. Ajuste le service de recuperation des photos Annudef pour eviter les exceptions en cas de probleme de connexion. Simplifie legerement la datatables des utilisateurs pour le cas de l'utilisation dans un composant composite.
- mieux mais pas fini
- pas fini mais sauv pour ce soir
- prise en compte des lachers anterieurs a la date embarquement
- correction pour nombre jours negatif
- prise en compte des ssobj validés avant d'embarquer => nb jour à 0 2eme essai
- prise en compte des ssobj validés avant d'embarquer => nb jour à 0
-  ajout d'une augmentation de la memory_limit car le traitement bloquait
- Retire le composant Blade de la fiche bilan, devenu inutile.
- Modification du parcours des fiches bilan. Remplacement du composant Blade par un composant Livewire.
- remise en place du changement de mot de passe local + bouton sur page d'accueil du site
- calcul du nb de jour validation pour les lachers fonction et sous obj lors de la validation
- Definit une route vers le point d'entree pour le parcours des fiches bilan.
- Cree un point d'entre du controlleur de la transformation pour afficher le nouveau composant de parcours des fiches bilan.
- Cree un composant Livewire pour parcourir les fiches bilan d'un ensemble de marins sélectionnés via une datatable.
- Modifier la vue fiche bilan pour utiliser le nouveau composant.
- Cree un composant Blade pour afficher la fiche bilan d'un marin.
- Ajoute le point date_embarq,0 dans l'historique de validation, des lors que la date_embarq est definie. S'assure que les dates sont bien rangees dans l'ordre chronologique.

## 1.1.4 (mars 10, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.1.3 –> 1.1.4
- Creation du service de recuperation des photos depuis l'annudef. Modification des vues users.edit et transformation.fichebilan pour utiliser cette photo plutot que la photo stockee sur le serveur. TODO: retirer les fonctionnalites de gestion des photos.

## 1.1.3 (mars 10, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.1.2 –> 1.1.3
- Corrige un bug introduit par erreur dans UsersTable. Definit un test Browser pour verifier la non regression sur ce point ulterieurement.

## 1.1.2 (mars 10, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.1.1 –> 1.1.2
- Retire l'acces aux Dashboard pour le moment.
- Ajout de tests browser pour les fonctions de recherche des utilisateurs et pour les fonctions d'archivage et de suppression.
- Corrige quelques bugs dans les fonctions d'archivage. Cree le service de generation de mot de passe aleatoire.
- Merge branch 'master' into tuleap-62250-inserer-une-solution-legere-pour-generer-des-graphiques-et-dashboard
- Modifie le master mayout pour inclure le javascript permettant de generer les graphiques des tableaux de bord.
- Merge branch 'master' into tuleap-62250-inserer-une-solution-legere-pour-generer-des-graphiques-et-dashboard
- Modifie le Dashboard pour placer chaque graphique dans un onglet.
- Add link to dashboard page in the navbar.
- Include asantibanez livewire-charts module. Create first dashboard setup.
- Merge branch 'master' into tuleap-61329-gerer-la-suppression-archivage-des-users
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/app_ffast
- modification page accueil du profil bord
- prise en compte des noms avec apostrophe dans stat etat major+ correction pour afficher les taux de transfo par fonction
- verification de la longueur du champ libelle court et libelle long
- ajout des colonnes libellé long pour la tache et l'objectif
- changement couleur navbar en fonction  APP_ENV est dev ou prod
- evolution de la doc
- correction syntaxe
- modif pour uniformisation des restauration avec creation d'un service
- Modifications dans MindefConnect et Annudef pour uniformiser la restauration d'un marin avec ou sans ses donnees.
- Mise a jour du test du controlleur User. Un utilisateur ne doit pas pouvoir etre supprimer si une date de debarquement n'a pas ete renseignee.
- Modification des processus d'archivage et de suppression.
- ajout unite_id lors de la création d'un user
- correction affichage liste grade ajout modif
- erreur
- correction affichage
- partie documentation
- correction affichage bouton retour
- correction affichage
- partie annudef
- partie mindefconnect
- verification si service rempli pour eviter affichage erreur sql à l'ecran
- partie qui concerne l'archivage

## 1.1.1 (mars 03, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.1.0 –> 1.1.1
- Corrige un bug d'affichage sur le livret de transformation lorsque le marin a propose la validation de son lache.

## 1.1.0 (mars 03, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.17 –> 1.1.0

## 1.0.17 (mars 03, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.16 –> 1.0.17
- Ajustements.
- Finalisation de l'optimisation des performances de l'application.
- WIP
- Travail en cours sur l'optimisation des performances.
- Mise a jour de la documentation pour la partir proposition d'elements a valider.
- Mise a jour de la documentation pour signaler la possibilite de proposer la validation d'elements du parcours de transformation.
- Poursuite de la modification pour permettre la proposition de validation des double et lache dans les fonctions par les marins eux memes.
- Premiere modification pour prendre en compte les propositions de validation de sous objectifs, objectifs et taches du parcours ainsi que du double d'une fonction.
- inversion modified/modifying pour rectifier l'affichage

## 1.0.16 (février 21, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.15 –> 1.0.16
- Retire la reference a \Fruitcake\Cors\HandleCors qui est deprecated et a ete introduit dans \Illuminate\Http\Middleware\HandleCors
- Retirer l'exemple de test remis en place par la mise a jour des packages.
- Updated all packages.
- Modification de l'historique des migrations. La table transformation_histories est cree directement dans son etat final afin d'éviter les migrations creant et detruisant des foreignID qui sont incompatibles avec SQLite, et qui cassent donc les tests automatiques.

## 1.0.15 (février 20, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.14 –> 1.0.15
- Commit de merger avec master avant de pouvoir reintegrer la nouvelle version
- Finalise la migration qui transforme la table d'historique pour retirer les user_id et mettre les displayname a la place.
- Rajoute un IF EXISTS dans la migration qui cree la vue bilan_transformation.
- Correct typo dans Modele TransformationHistory
- changement user id en display name

## 1.0.14 (février 20, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.13 –> 1.0.14
- Modifie le nom du parametre pour l'aligner avec la definition des routes pour que le type-binding du Service Container se fasse bien.
- Corrige la migration qui supprime les champs modified_user_id et modifying_user_id de la table transformation_histories.
- oubli fichier
- 2eme essai
- modif enlevees pour pouvoir merger. je les remets dans une autre branche
- Merge branch 'master' into tuleap-50242-etudier-la-pertinence-de-la-fonction-mer
- validation inutile car ce fichier est à revoir
- ajout colonne unite destination libcourt pour les listes de marins
- ajout du commentaire personnel pour les marins déjà validés
- remise en place de la vue de la liste des satges à associe à une fonction
- remise en place de la vue de la liste des satges à associe à une fonction
- Remove reference to database name which is useless and would generate issues if the name was changed later.
- modif table hitoriqur pour rendre valeur null possible pour les champs userid
- Merge branch 'master' into tuleap-50242-etudier-la-pertinence-de-la-fonction-mer
- modification pour avoir le display name à la place du user id dans la table historique de la transfo
- Ajuste la migration pour la vue bilan_transformation
- Cree la vue bilan_transformation qui met a plat toutes les informations relatives aux utilisateurs et a leur transformation.
- Add version badge in navbar
- Merge branch 'master' into tuleap-50242-etudier-la-pertinence-de-la-fonction-mer
- modif page de garde pour plusieurs fonc mer
- évolution affichage des boutons dans les users à archiver pour ne plus pouvoir archiver quelqu'un qui n'a pas de date de débarquement
- modif affichage statuteurtable pour mettre toutes les fonc mer
- suppression affichage de la fonc mer car il peut y en avoir plusieurs
- attribution de plusieurs fonctions mer possible

## 1.0.13 (février 09, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.12 –> 1.0.13
- Correct MailsTest test and add some pauses to ensure tests succeeds despite ajax delays.
- Merge commit '400549f07a1a3e45d282e348062797e79b31c1c6'
- Created dusk tests; Adjusted dusk selectors in views
- Merge branch 'master' into modifdoc
- ajout précision concernant validation double/lacher
- ajout recalcul tx transfo lors ajout/suppr d'une fonction
- evolution affichage gestion users
- modif page accueil des transfos et des affichages pour les tables livewire stattuteur et user
- Merge branch 'master' into modifdoc
- amélioration doc

## 1.0.12 (février 06, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.11 –> 1.0.12
- Reinserted metabase configuration database into app_ffast repository.
- Adjust .env database settings.
- Adjust initialize env script
- Adjust permissions on hooks.
- Adjusted scripts
- Purged repository from stack data and moved application to the root.
- Removed scopeLocal reference in Fonction Model.
- Add gitignore for vendor autoload files.
- Reintroduce prefix un livewire routes.
- Updated vendor folder. Added san-kumar/laravel-crud.
- Cleanup code
- Clean up User model
- Cleanup du code
- Remove scopeLocal reference in UsersController
- Restore PermissionSeeder to its original state.
- Adjusted database seeders to new routes definition.
- Cree le GererTransformationService qui rassemble le code permettant de gerer les relations entre les donnees en base pour retranscrire le processus de transformation.
- Cleanup StageController. TODO: cleanup create method.

## 1.0.11 (janvier 31, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.10 –> 1.0.11
- Removed useless Event and Listener.
- Removed NGINX parameters in .env files. Removed register and unregister artisan commands.
- Change restart policy of all containers

## 1.0.10 (janvier 30, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.9 –> 1.0.10
- Added label definition in stack for traefik integration
- Useless commit to test deploy strategy.

## 1.0.9 (janvier 25, 2023) 
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.8 –> 1.0.9
- Adds APP_VERSION to slug files, and adjust bump_app_prefix script to update the value in generated env files.
- ajout bouton ? pour lien vers la doc
- maj doc admin/archivage ajout bouton telecharg livret
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/ffast into tuleap-40560-suppression-d-un-user
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/ffast into tuleap-53243-revoir-toutes-les-stats
- Redefinit les routes de redirection du module lab404/impersonate afin que l'utilisateur ne soit pas renvoye hors de l'instance lorsqu'il utilise ces fonctions.
- correction ortho
- Merge branch 'master' into tuleap-53243-revoir-toutes-les-stats
- maj doc transformation suite ajout menu recalcul tx transfo
- ajout du menu/transfo/recalcultransfo pour pouvoir relancer le calcul de tous les tx de transfo pour tous les utilisateurs
- Merge branch 'master' into tuleap-40560-suppression-d-un-user
- ajout bouton  telecharger livret car impossible de faire une redirection apres mpdf->output() donc de remettre à jour l'affichage

## 1.0.8 (janvier 23, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.7 –> 1.0.8
- Inversion de la logique dans la commande RecalculerTransformation pour ne pas toucher aux dossiers des marins archives, et seulement toucher aux dossiers des marins non archives.

## 1.0.7 (janvier 23, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.6 –> 1.0.7
- Retrait de la commande RecalculTxTransfo superflue car en doublon de la commande RecalculerTransformation.
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/ffast into tuleap-53243-revoir-toutes-les-stats
- Modification de la commande de recalcul des taux de transformation et des durees de validation pour ne pas recalculer les elements des utilisateurs archives. Sinon, on risque de fausser les statistiques en cas de modification, dans l'intervalle, du parcour de transformation.
- Creation du champs nb_jours_pour_validation dans la table user_fonction. Ajout du calcul du nb de jours jusqu'au lache dans la table user_fonction.
- correction suite demande 55326 : le nb marin à valider etait faux
- 2eme essai
- Merge branch 'master' into tuleap-53243-revoir-toutes-les-stats
-  modif calcul tx transfo car il peut y avoir des ssobj orphelins
- Separer la commande de suppression des doubles et la commande de calcul des taux de transformation et du nombre de jour avant la validation des sous objectifs pour ne pas forcer les 2 operations. Ajoute le champs nb_de_jours_avant_validation a la table pivot user_sous_objectif.
- Added MB_SITE_URL environnement variable to the metabase docker-compose definition.
- lors de la suppression d'une fonction pour un user, on n'enleve plus ni les stages ni les sssobj validés

## 1.0.6 (janvier 12, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.5 –> 1.0.6
- Changed the way the prefix is bumped into the stack. Removed automaticaly generated files of composer (autoload).
- Merge branch 'master' into tuleap-54260-integrer-une-solution-de-tableau-de-bord-indicateurs
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.5 –> 1.0.6
- Correct dusk tests to create an admin user for the duration of the tests.
- Correct bump_app_prefix script: must generate usable .env files and not update .slugs
- Move the prefix issue up by moving .env files to slugs for each environment. Theses slugs are personalized when the instance is created.
- Merge branch 'master' into tuleap-53243-revoir-toutes-les-stats
- Add metabase container to the stack. Add /metabase location to nginx.conf. Metabase user data-analyst@ffast.intradef.gouv.fr / ffast83
- corrections orthographiques
- Create new command to suppress duplicate entries in user_sous_objectif table.
- remplacement de substr par round pour les tx de transfo
- mise à jour de la doc en ligne
- corrections syntaxiques
- correction requete selection users: manquait or deleted_at not null
- Update compose autoload
- Merge branch 'master' into tuleap-53243-revoir-toutes-les-stats
- remplacement du tableau duree lacher par marin par une table livewire
-  ajout fonction GenerateStatistics dans StatService pour re-calcul
- revision des calculs de stat et activation du bouton recalcul
- changement des libelles du menu statistique
- evolution presentation ecran indicateurs
- remplacement du code pour impression pdf par le service dans transfocontroller

## 1.0.6 (janvier 11, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.5 –> 1.0.6
- Correct dusk tests to create an admin user for the duration of the tests.
- Correct bump_app_prefix script: must generate usable .env files and not update .slugs
- Move the prefix issue up by moving .env files to slugs for each environment. Theses slugs are personalized when the instance is created.
- Add metabase container to the stack. Add /metabase location to nginx.conf. Metabase user data-analyst@ffast.intradef.gouv.fr / ffast83
- Create new command to suppress duplicate entries in user_sous_objectif table.
- Update compose autoload
- Merge branch 'master' into tuleap-53243-revoir-toutes-les-stats
- remplacement du tableau duree lacher par marin par une table livewire
-  ajout fonction GenerateStatistics dans StatService pour re-calcul
- revision des calculs de stat et activation du bouton recalcul
- changement des libelles du menu statistique
- evolution presentation ecran indicateurs
- remplacement du code pour impression pdf par le service dans transfocontroller

## 1.0.5 (janvier 05, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.4 –> 1.0.5
- Changes the name of the dusk settings file. Dusk tests cannot run in testing environnement because the testing environnement comes with an in memory sqlite database settings which makes all data volatile.
- Adjusted settings and paths for the testing scenario. Testing instance should always be instanciated as testing.
- Added some tests in reset_app_prefix script to avoid spurious error messages.
- Add livrets directory and .gitignore
- Remove test pdf livrets
- Remove color difference in navbar
- Merge branch 'master' into tuleap-40560-suppression-d-un-user
- Really fix merge conflict
- Fix merge conflict
- modif du calcul stat pour prise en compte des users softdeleted
- ajout de la fonctionnalité archivage

## 1.0.4 (janvier 05, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.3 –> 1.0.4
- The WebRoutesTest is modified to un cache the routes after the route caching test because it appears that route caching does not take the APP_PREFIX into account as it should, resulting in broken routes.
- Adjust image path in generalite doc page to reflect file structure
- Moved doc imaged for generalites in the appropriate folder.
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/ffast into tuleap-53184-declaration-de-routes-en-double
- Add assertion to WebRoutesTest
- update composer autoload
- Implement tests, factory, correct bugs in LienController
- Create test to reproduce the bug
- Cleanup repository ffast-stack
- Correct nginx.conf state for master branch
- Staged composer dump-autoload result
- Merge branch 'master' into tuleap-53080-mise-a-jour-de-la-documentation
- Adjuste env.production file to point to the appropriate doc version
- Created .env for each environnement. Modified bump and reset prefix script to handle the .env setup and reset.
- Added help link in all pages

## 1.0.3 (janvier 04, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.2 –> 1.0.3

## 1.0.2 (janvier 04, 2023)
- Updated VERSION, Updated CHANGELOG.md, Bumped 1.0.1 –> 1.0.2
- Added bump-version.sh script and initialized changelog and VERSION file
- adjust doc administration
- Add administration doc
- Adjust doc
- Adjust doc
- Created statistiques documentation page
- Cleanup documentation images
- Insere la documentation tuteur dans larecipe
- Added screenshot of navbar when logged in.
- Unstaged general .env
- Adjusted bump and reset scripts
- Make sure tests/Unit directory exists.
- Correct .env files
- Corrected details for testing integration
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/ffast into create_first_tests
- Continue test implementation.
- Adjust testing configuration for Dusk.
- Correct APP_URL (remove final slash)
- Remove APP_PREFIX from APP_URL. Is useless, and confuses phpunit for testing.
- Cleanup database configuration
- First trial with dusk selectors.
- Adds basic HTTP tests. Initialize Dusk configuration for browser tests. Duplicates docker-compose file to have a production and a testing version.
- Begin test implementation for UserController.
- First real test for LoginController
- Cleanup tests directory
- Change testing settings to include temporary sqlite database
- Updated Models factory to permit testing
- Add test condition on roles to avoid unecessary errors on localogin
- Trial at linking image into doc
- Created public folder to serve documentation images and resources
- First elements of doc
- Create DOC_VERSION env variable.
- Started creating documentation page. Created a DOC_VERSION env variable so that we point to the appropriate version of the doc.
- Correct larecipe template to use instance urls
- Introduce blade component to redirect user towards the documentation. Make the pages layout so that the documentation reference is defined in each blade view.
- Merge branch 'master' of ssh://forge.intradef.gouv.fr/ffast/ffast into tuleap-52400-integrer-un-systeme-de-documentation
- Added question mark to navbar
- composer dump-autoload
- Fixed.
- artisan dusk:install
- composer require --dev laravel/dusk
- Adjust larecipe path for APP_PREFIX
- php artisan larecipe:install
- composer require binarytorch/larecipe
- Change user order by in livewire component
- Merge branch 'master' into release-1
- Fixe conflit
- Update release branch
- Adjust configuration for production
- Configuration change for production

