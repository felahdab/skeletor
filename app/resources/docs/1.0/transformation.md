# Transformation

- Suivi de la transformation par marin
- Suivi de la transformation par fonction
- Suivi de la transformation par stage


<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/menu_transformation.png' )) }}" width=400px>
Ce menu permet d’accéder : 
 
1. à la liste des marins en cours de transformation. Un lien vers son livret de transformation permet la validation d’objectifs.
2. à la liste des fonctions. Un lien vers le livret associé à la fonction permet la validation collective d’objectifs.
3. à la liste des stages. Permet de consulter la liste des marins en attente de ce stage ou ceux l’ayant déjà validé.

## Suivi de la transformation par marin
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/suivi_par_marin.png' )) }}" width=1000px>
1. Vous retrouvez dans cette liste tous les marins en transformation.
2. Le filtre vous permet de n’afficher que les personnels dont le nom ou le prénom contient la chaine de caractères saisie.
3. Les filtres vous permettent d’affiner votre recherche :

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/filtre_users.png' )) }}" width=600px>
4. Vous pouvez paramétrer l’affichage : le bouton colonne vous permet de cacher/afficher les colonnes selon vos besoins et le nombre est le nombre de lignes affichées sur la page courante.
5. Ces boutons vous permettent d’accéder aux données du marin. Attention : selon votre profile, certains boutons peuvent ne pas être accessibles.
 
### Attribuer des fonctions
Écran permettant l’attribution et le retrait de fonction à un marin.
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/attribution_fonctions.png' )) }}" width=600px>
1. Identité du marin concerné
2. Liste des fonctions attribuées. Le bouton (3) « Retirer cette fonction » retire la fonction au marin.
4. Sélectionnez dans la liste déroulante la fonction à attribuer puis cliquez sur « Attribuer cette fonction » pour valider.
5. Une fois les fonctions attribuées, accédez directement au livret de transformation du marin.
6. Le bouton « Retour » permet de revenir à la liste des marins en transformation.

### Livret de transformation
Écran permettant la consultation et la validation des objectifs associés aux fonctions du marin.
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/livret_de_transformation.png' )) }}" width=1000px>
La barre de navigation (1) permet l’accès direct aux autres affichages concernant le marin sélectionné.
(2) Retrouvez la liste des fonctions du marin. Cliquez sur la ligne pour voir l’ensemble des tâches, objectifs (6), stages (7) et état de lâcher (8) associés à une fonction. 

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/livret_de_transformation_developpe.png' )) }}" width=1000px> 

Pour valider des sous-objectifs, objectifs ou tâches (9, 10, 11), cocher la ou les case(s) à cocher adjacente(s) puis cliquer sur le bouton « Valider les éléments cochés » (3). L’écran de validation suivant s’affiche :

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/livret_de_transformation_validation.png' )) }}" width=600px> 
Saisir les données nécessaires. Pour enregistrer les validations, cliquer sur le bouton « Valider ».

**Remarques :**
- la date est par défaut la date du jour.
- le valideur est par défaut la personne connectée.
- le commentaire n’est pas obligatoire.

Il vous est possible d’annuler des validations en cochant les cases voulues (9, 10, 11))puis en cliquant sur « Annuler la validation des éléments cochés » (4). 
Attention, aucune confirmation de suppression n’est demandée.
Pour valider un double ou un lâcher, cliquer sur le bouton « valider » (12,13) de la ligne concernée. L’écran suivant s’affiche :
 
Saisir les données nécessaires. Pour enregistrer les validations, cliquer sur le bouton « Valider ».

**Remarques :  **
- la date est par défaut la date du jour.
- le valideur est par défaut la personne connectée.
- il est fortement recommandé de saisir un commentaire pour le double et le lâcher.

Le bouton « Imprimer » (5) permet d’éditer le livret au format pdf.

**Remarque : **Pour l’imprimer au format livret, sélectionnez l’option d’impression d’Acrobate Reader « brochure ».
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/livret_de_transformation_impression_livret.jpg' )) }}" width=600px> 

### Progression
Représentation graphique du taux de transformation global puis par fonction.
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/progression.png' )) }}" width=600px> 
On retrouve le titre de la fonction (1) (2), le taux de transformation pour cette fonction (3) (4), la liste des stages associés (5) (6) et le taux d’avancement par compagnonnage (7) (8). 
        Somme coefficients sous objectifs validés + nb stages validés
Tx transfo =                                                                                                                    x 100
		       Somme coefficients sous objectifs + nb stages
### Fiche bilan

Récapitulatif des données de transformation pour le marin sélectionné. On retrouve sous forme de tableau, le taux d’avancement pour chaque compagnonnage et la liste des stages associés aux fonctions. Un en-tête reprécise les données personnelles.
 
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/fiche_bilan.png' )) }}" width=600px> 
 
### Stages
Liste des stages associés aux fonctions du marin sélectionné. 
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/stages_user.png' )) }}" width=600px> 

Le bouton « Situation des marins pour ce stage » vous redirige vers l’affichage de tous les marins concernés par un stage.

## Suivi de la transformation par fonction
Permet de valider des objectifs ou des tâches pour plusieurs marins en même temps.
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/transformation_par_fonction.png' )) }}" width=600px> 

Le bouton « Liste marins » (1) affiche la liste des marins ayant cette fonction avec leur taux de transformation.
Cliquez sur le bouton « Validation collective » (2) pour afficher le tableau récapitulatif des sous-objectifs rattaché à cette fonction.
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/transformation_par_fonction_developpe.png' )) }}" width=600px> 

Cocher les cases à cocher correspondantes aux tâches, objectifs ou sous-objectifs à valider puis cliquer sur le bouton « Enregistrer les validations » (3). L’écran suivant s’affiche :
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/transformation_par_fonction_validation_collective.png' )) }}" width=600px> 

Sélectionner les marins à valider. Pour cela, cliquer sur les marins voulus en maintenant enfoncée la touche « Ctrl » de votre clavier. Cliquer ensuite sur le bouton « valider » pour enregistrer les validations. 
Remarques :  - tous les marins auront la même date, le même valideur et le même commentaire.
- la date est par défaut la date du jour.
- le valideur est par défaut la personne connectée.
- Les doubles et lâchers ne peuvent pas être validés de cette façon.

## Suivi de la transformation par stage
Cette page permet de consulter la situation des marins pour un stage.
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/transformation_par_fonction_validation_collective.png' )) }}" width=600px> 

En cliquant sur le bouton « Situation des marins pour ce stage » (1), vous afficher deux listes. La première recense les marins en attente du stage (2), la deuxième (3), ceux l’ayant déjà validé. En cliquant sur un nom (4), vous revenez au détail des stages du marin.
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/transformation_par_fonction_validation_collective.png' )) }}" width=600px> 
 
Remarque : pour exporter ce tableau sous Excel, sélectionner toutes les cases voulues en maintenant enfoncée la touche « Ctrl » de votre clavier puis copier et coller.



# Ma Transformation
Ce menu n’est visible que si vous avez une fonction de service. 
Vous y retrouvez sur le même modèle que dans le menu « Transformation » :
- votre livret de transformation,
- vos diagrammes de progression,
- votre fiche bilan.

# Statistiques
Ce menu vous permet d’afficher le tableau récapitulatif des taux de transformation des marins de votre service.
Remarque : seuls les marins ayant au moins une fonction de service apparaissent dans cette liste.
<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/transformation/bilan_pour_tuteurs_et_em.png' )) }}" width=600px> 
Pour chaque marin, vous pouvez consulter l’ensemble des fonctions qui lui sont attribuées (1))et son taux de transformation global(2)). Vous pouvez accéder à son livret, ses courbes de progression et sa fiche bilan avec les boutons(3)).
