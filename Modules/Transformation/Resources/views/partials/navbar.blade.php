
            @canAny(['transformation::transformation.exportparcours',
                    'transformation::stages.index', 
                    'transformation::objectifs.index', 
                    'transformation::taches.index',
                    'transformation::compagnonages.index',
                    'transformation::fonctions.index'])
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Parcours
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @can('transformation::fonctions.index')<a class="dropdown-item" href="{{ route('transformation::fonctions.index')}}">Fonctions</a>@endcan
                @can('transformation::compagnonages.index')<a class="dropdown-item" href="{{ route('transformation::compagnonages.index')}}">Compagnonnages</a>@endcan
                @can('transformation::taches.index')<a class="dropdown-item" href="{{ route('transformation::taches.index')}}">Tâches</a>@endcan
                @can('transformation::objectifs.index')<a class="dropdown-item" href="{{ route('transformation::objectifs.index')}}">Objectifs</a>@endcan
                @can('transformation::stages.index')<a class="dropdown-item" href="{{ route('transformation::stages.index')}}">Stages</a>@endcan
                @can('transformation::transformation.exportparcours')<a class="dropdown-item" href="{{ route('transformation::transformation.exportparcours')}}">Exporter les parcours</a>@endcan
              </div>
            </div>
            @endcan
            @canAny(['transformation::transformation.index',
                    'transformation::transformation.indexparfonction', 
                    'transformation::transformation.indexparcomp', 
                    'transformation::transformation.indexparstage',
                    'transformation::transformation.parcoursfichebilan', 
                    ])
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Suivi Transfo
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                @can('transformation::transformation.index')<a class="dropdown-item" href="{{route('transformation::transformation.index')}}">Suivi de la transformation par marin</a>@endcan
                @can('transformation::transformation.indexparfonction')<a class="dropdown-item" href="{{route('transformation::transformation.indexparfonction')}}">Suivi de la transformation par fonction</a>@endcan
                @can('transformation::transformation.indexparcomp')<a class="dropdown-item" href="{{route('transformation::transformation.indexparcomp')}}">Suivi de la transformation par compagnonnage</a>@endcan
                @can('transformation::transformation.indexparstage')<a class="dropdown-item" href="{{route('transformation::transformation.indexparstage')}}">Suivi de la transformation par stage</a>@endcan
                @can('transformation::transformation.parcoursfichebilan')<a class="dropdown-item" href="{{route('transformation::transformation.parcoursfichebilan')}}">Parcours des fiches bilan</a>@endif
              </div>
            </div>
            @endcan
            @canAny(['transformation::transformation.recalcultransfo',
                    'transformation::historique.index',
                    'transformation::archivage.index',
                    'transformation::miseenvisibilite.index'])
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Gestion Transfo
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                @can('transformation::transformation.recalcultransfo')<a class="dropdown-item" href="{{route('transformation::transformation.recalcultransfo')}}">Recalcul des taux transformation</a>@endcan
                @can('transformation::historique.index')<a class="dropdown-item" href="{{ route('transformation::historique.index')}}">Historique</a>@endcan
                @can('transformation::archivage.index')<a class="dropdown-item" href="{{ route('transformation::archivage.index')}}">Archivage</a>@endcan
                @can('transformation::miseenvisibilite.index')<a class="dropdown-item" href="{{ route('transformation::miseenvisibilite.index')}}">Partage dossier</a>@endcan
              </div>
            </div>
            @endcan
            {{-- @if(auth()->user()->en_transformation) --}}
            @php
              use Modules\Transformation\Entities\User;
              $user=User::find(auth()->user()->id);
            @endphp
            @if($user->en_transformation)
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Ma transformation
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{route('transformation::transformation.monlivret')}}">Mon livret</a>
                <a class="dropdown-item" href="{{route('transformation::transformation.maprogression')}}">Ma progression</a>
                <a class="dropdown-item" href="{{route('transformation::transformation.mafichebilan')}}">Ma fiche bilan</a>
              </div>
            </div>
            @endif
            
            @if (auth()->user()->canAny(['transformation::statistiques.index', 
                                         'transformation::statistiques.statpourunservice', 
                                         'transformation::statistiques.statstage',
                                         'transformation::statistiques.statglobal']))
            <div class="dropdown" >
              <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Statistiques
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @can('transformation::statistiques.statpourunservice')<a class="dropdown-item" href="{{route('transformation::statistiques.statpourunservice')}}">Bilan par service</a>@endcan
                @can('transformation::statistiques.statstage')<a class="dropdown-item" href="{{route('transformation::statistiques.statstage')}}">Bilan par stage</a>@endcan
                @can('transformation::statistiques.statglobal')<a class="dropdown-item" href="{{route('transformation::statistiques.statglobal')}}">Bilan global</a>@endcan
                @can('transformation::statistiques.index')<!--a class="dropdown-item" href="{{route('transformation::statistiques.index')}}">Indicateurs</a-->@endcan
                @can('transformation::statistiques.dashboard')<a class="dropdown-item" href="{{route('transformation::statistiques.dashboard')}}">Tableau de bord</a>@endcan
                @can('transformation::statistiques.dashboardarchive')<a class="dropdown-item" href="{{route('transformation::statistiques.dashboardarchive')}}">Archives</a>@endcan
                
              </div>
            </div>
            @endif
            
