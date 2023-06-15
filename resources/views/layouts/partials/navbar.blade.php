@section('helplink')
  < x-help-link page="connexion"/>
@endsection



@if (env('APP_ENV') == 'dev')
  <nav class="navbar navbar-expand-lg navbar-light sticky-top " style="background-color: rebeccapurple;">
@else
  <nav class="navbar navbar-expand-lg navbar-light bg-dark sticky-top ">
@endif


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse container-fluid" id="navbarTogglerDemo01">
        <ul class="navbar-nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 mr-auto mt-2 mt-lg-0">
             <a href="{{ route('home.index') }}" class="btn btn-outline-light me-2">Accueil</a>
            @auth
            @can('users.index')
            <div class="dropdown nav-item" >
              <button dusk="administration-button" class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Administration
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @can('mindefconnect.index')<a class="dropdown-item" href="{{ route('mindefconnect.index') }}">Demandes Mindef Connect</a>@endcan
                <a class="dropdown-item" href="{{ route('users.index') }}">Fiches des marins</a>
                @can('roles.index')<a class="dropdown-item" href="{{ route('roles.index')}}">Roles</a>@endcan
                @can('permissions.index')<a class="dropdown-item" href="{{ route('permissions.index')}}">Droits d'acces</a>@endcan
                @can('liens.index')<a class="dropdown-item" href="{{ route('liens.index')}}">Liens</a>@endcan
                @can('historique.index')<a class="dropdown-item" href="{{ route('historique.index')}}">Historique</a>@endcan
                @can('annudef.index')<a class="dropdown-item" href="{{ route('annudef.index')}}">Annudef</a>@endcan
                @can('archivage.index')<a class="dropdown-item" href="{{ route('archivage.index')}}">Archivage</a>@endcan
                @can('mails.index')<a class="dropdown-item" href="{{ route('mails.index')}}">Mails</a>@endcan
              </div>
            </div>
            @endcan
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
            
            @endauth
        </ul>
      

      @auth
        @impersonating()
            <a href="{{ route('impersonate.leave') }}" class="btn btn-outline-danger me-2">Redevenir soi-m&ecirc;me</a>
	      @endImpersonating
        
        <button type= "button" class='btn btn-warning' data-bs-toggle="modal" data-bs-target="#bugreport-modal"> Signaler un problème</button> 
        
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#notificationPanel" aria-controls="offcanvasRight"><x-bootstrap-icon iconname='bell.svg' /></button>

        <div class="dropdown">
          <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ auth()->user()->display_name }}
          </button>
          <div class="dropdown-menu" style="position:absolute;right:0; left:auto;" aria-labelledby="dropdownMenuButton">
            @yield('helplink')
            <a class="dropdown-item" href="{{ route('changepasswd.show', auth()->user()) }}">Changer mot de passe</a>
            <div class="dropdown-item">Mes rôles:
              @foreach(auth()->user()->roles as $role)
                <span class="badge bg-primary">{{ $role->name }}</span>
              @endforeach
            </div>
            @can('mespreferences')<a class="dropdown-item" href="{{ route('mespreferences') }}">Préférences</a>@endcan
            <a class="dropdown-item" href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Déconnexion</a>
            <hr>
            <span class="dropdown-item">Version : {{env('APP_VERSION')}}</span>
          </div>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <span class="btn btn-outline-light me-2">@yield('helplink')</span>
          <a href="{{ route('login.show') }}" class="btn btn-outline-light me-2">Login</a>
        </div>
      @endguest
      
    </div>
  </div>
</nav>
