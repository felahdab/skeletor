# Statistiques

- [Bilan par service](#bilan-service)
- [Bilan par stage](#bilan-stage)
- [Bilan global](#bilan-global)
- [Indicateurs](#indicateurs)

> {info} Pour exporter ces tableaux sous Excel, sélectionnez toutes les cases voulues en maintenant enfoncée la touche « Ctrl » de votre clavier puis copiez et collez dans votre fichier Excel.

<a name="bilan-service">
## Bilan par service
Page permettant d’afficher le tableau récapitulatif des taux de transformation des marins d'un service.

Pour chaque marin, vous pouvez consulter l’ensemble des fonctions qui lui sont attribuées (1) et son taux de transformation global(2). Vous pouvez accéder à son livret, ses courbes de progression et sa fiche bilan avec les boutons(3).

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/statistiques/bilan_pour_tuteurs_et_em.png' )) }}" width=1000px> 

** Remarque : ** Seuls les marins ayant au moins une fonction attribuée apparaissent dans cette liste.

<a name="bilan-stage">
## Bilan par stage
Page permettant d’afficher un tableau récapitulant le nombre de marins en attente de validation d’un stage sous licence (1) et un tableau récapitulant le nombre de marins en attente de validation d’un stage extérieur (2).

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/statistiques/bilan_stages.png' )) }}" width=1000px> 

<a name="bilan-global">
## Bilan global
Page permettant d’afficher un tableau récapitulant le nombre de marins en transformation par service(1) et un tableau récapitulant le nombre de marins en transformation par fonction de service à quai (2).

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/statistiques/bilan_global.png' )) }}" width=1000px> 

** Remarque : ** En cliquant sur un service ou une fonction de service à quai, vous affichez la liste des marins concernés.


<a name="indicateurs">
## Indicateurs
Page permettant d’afficher l'ensemble des données brutes pour établir des statistiques. Selectionnez la période que vous souhaitez afficher (1). Par défaut, la période affichée est la plus récente.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/statistiques/indicateurs.png' )) }}" width=400px> 

> {info} Seuls les marins archivés sont pris en compte pour établir ces statistiques c'est à dire qu'un marin débarqué qui n'a pas été archivé n'apparaitra pas dans cette page.

Le bouton "Recalculer cette période" (2) permet de recalculer les statistiques pour la période sélectionnée.

On retrouve 3 onglets :

### Indicateurs (3): 

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/statistiques/indic_onglet_indic.png' )) }}" width=1000px> 

- Nb marins : nombre de marins concernés.
- Taux SAE achevé : nombre de stages validés x 100 / nombre de stages à faire.
- Taux compagnonnage achevé :nombre de sous-objectifs validés x 100 / nombre de sous-objectifs à faire.
- Taux transformation :(nombre de sous-objectifs validés + nombre de stages validés) x 100 / (nombre de sous-objectifs à faire + nombre de stages à faire).
- Nb jours de présence : Nombre de jours entre la date d'embarquement et la date de débarquement.
- Nb marins lâchés quai : Nombre de marins étant lâchés dans leur fonction à quai.
- Nb marins lâchés mer : Nombre de marins étant lâchés dans leur fonction à la mer.
- Nb marins lâchés quai+mer : Nombre de marins étant lâchés dans leur fonction à quai et à la mer.

### Temps de lâcher par marin (4) :
Tableau listant les temps de lâcher dans les différentes fonctions pour chaque marin.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/statistiques/indic_onglet_marin.png' )) }}" width=1000px> 

- Taux transformation :(nombre de sous-objectifs validés + nombre de stage validés) x 100 / (nombre de sous-objectifs à faire + nombre de stages à faire).
- Fonc quai : Nombre de jours entre la date d'embarquement et la date de lâcher pour la fonction à quai.
- Fonc mer : Nombre de jours entre la date d'embarquement et la date de lâcher pour la fonction à la mer.
- Fonc metier : Nombre de jours entre la date d'embarquement et la date de lâcher pour la fonction métier. S'il y en a plusieurs, la différence est faite avec la plus récente.
- Présence : Nombre de jours entre la date d'embarquement et la date de débarquement.

### Temps de lâcher par brevet et spécialité (5):
Tableau listant les temps de lâcher moyens dans les fonctions à quai et à la mer par brevet et par spécialité.

<img src="{{ url(asset('docs/images/' . env('DOC_VERSION') . '/statistiques/indic_onglet_spe.png' )) }}" width=600px> 

- Fonc quai : Moyenne du nombre de jours entre la date d'embarquement et la date de lâcher pour la fonction à quai.
- Fonc mer : Moyenne du nombre de jours entre la date d'embarquement et la date de lâcher pour la fonction à la mer.
- Présence : Moyenne du nombre de jours entre la date d'embarquement et la date de débarquement. 


