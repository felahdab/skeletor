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

