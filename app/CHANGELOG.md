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

