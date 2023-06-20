
            @can('transformation.exportparcours')
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Parcours
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @can('fonctions.index')<a class="dropdown-item" href="{{ route('fonctions.index')}}">Fonctions</a>@endcan
                @can('compagnonages.index')<a class="dropdown-item" href="{{ route('compagnonages.index')}}">Compagnonnages</a>@endcan
                @can('taches.index')<a class="dropdown-item" href="{{ route('taches.index')}}">Tâches</a>@endcan
                @can('objectifs.index')<a class="dropdown-item" href="{{ route('objectifs.index')}}">Objectifs</a>@endcan
                @can('stages.index')<a class="dropdown-item" href="{{ route('stages.index')}}">Stages</a>@endcan
                <a class="dropdown-item" href="{{ route('transformation.exportparcours')}}">Exporter les parcours</a>
                <!--a class="dropdown-item" href="{{ route('sous-objectifs.index')}}">Sous-Objectifs</a-->
              </div>
            </div>
            @endcan
            @can('transformation.index')
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Transformation
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                <a class="dropdown-item" href="{{route('transformation.index')}}">Suivi de la transformation par marin</a>
                @can('transformation.indexparfonction')<a class="dropdown-item" href="{{route('transformation.indexparfonction')}}">Suivi de la transformation par fonction</a>@endcan
                @can('transformation.indexparcomp')<a class="dropdown-item" href="{{route('transformation.indexparcomp')}}">Suivi de la transformation par compagnonnage</a>@endcan
                @can('transformation.indexparstage')<a class="dropdown-item" href="{{route('transformation.indexparstage')}}">Suivi de la transformation par stage</a>@endcan
                @can('transformation.recalcultransfo')<a class="dropdown-item" href="{{route('transformation.recalcultransfo')}}">Recalcul des taux transformation</a>@endcan
                @can('transformation.parcoursfichebilan')<a class="dropdown-item" href="{{route('transformation.parcoursfichebilan')}}">Parcours des fiches bilan</a>@endif
                @can('historique.index')<a class="dropdown-item" href="{{ route('historique.index')}}">Historique</a>@endcan
                @can('archivage.index')<a class="dropdown-item" href="{{ route('archivage.index')}}">Archivage</a>@endcan
              </div>
            </div>
            @endcan
            @if(auth()->user()->en_transformation)
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Ma transformation
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{route('transformation.monlivret')}}">Mon livret</a>
                <a class="dropdown-item" href="{{route('transformation.maprogression')}}">Ma progression</a>
                <a class="dropdown-item" href="{{route('transformation.mafichebilan')}}">Ma fiche bilan</a>
              </div>
            </div>
            @endif
            
            @if (auth()->user()->can('statistiques.index') or auth()->user()->can('statistiques.pourtuteurs') or auth()->user()->can('statistiques.pour2ps') or auth()->user()->can('statistiques.pourem'))
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Statistiques
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @can('statistiques.pourtuteurs')<a class="dropdown-item" href="{{route('statistiques.pourtuteurs')}}">Bilan par service</a>@endcan
                @can('statistiques.pour2ps')<a class="dropdown-item" href="{{route('statistiques.pour2ps')}}">Bilan par stage</a>@endcan
                @can('statistiques.pourem')<a class="dropdown-item" href="{{route('statistiques.pourem')}}">Bilan global</a>@endcan
                @can('statistiques.index')<!--a class="dropdown-item" href="{{route('statistiques.index')}}">Indicateurs</a-->@endcan
                @can('statistiques.dashboard')<a class="dropdown-item" href="{{route('statistiques.dashboard')}}">Tableau de bord</a>@endcan
                @can('statistiques.dashboardarchive')<a class="dropdown-item" href="{{route('statistiques.dashboardarchive')}}">Archives</a>@endcan
                
              </div>
            </div>
            @endif
            
