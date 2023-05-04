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

