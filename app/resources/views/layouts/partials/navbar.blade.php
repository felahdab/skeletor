<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon bg-light"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <ul class="navbar-nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 mr-auto mt-2 mt-lg-0">
        <li><a href="/" class="nav-link nav-item text-white">Accueil</a></li>
        @auth
        @can('users.index')
        <div class="dropdown nav-item" >
          <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Personnel
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('users.index') }}">Utilisateurs</a>
            <a class="dropdown-item" href="{{ route('roles.index')}}">Roles</a>
            <a class="dropdown-item" href="{{ route('permissions.index')}}">Permissions</a>
          </div>
        </div>
        @endcan
        @hasrole('2ps')
        <div class="dropdown" >
          <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Fonctions
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('fonctions.index')}}">Fonctions</a>
            <a class="dropdown-item" href="{{ route('compagnonages.index')}}">Compagnonages</a>
            <a class="dropdown-item" href="{{ route('taches.index')}}">Taches</a>
            <a class="dropdown-item" href="{{ route('objectifs.index')}}">Objectifs</a>
            <a class="dropdown-item" href="{{ route('sous-objectifs.index')}}">Sous-Objectifs</a>
          </div>
        </div>
        <div class="dropdown" >
          <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Stages
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('stages.index')}}">Stages</a>
          </div>
        </div>
        @endrole
        @hasrole('tuteur')
        <div class="dropdown" >
          <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Transformation
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
            <a class="dropdown-item" href="{{route('transformation.index')}}">Suivi de la transformation par marin</a>
            <a class="dropdown-item" href="{{route('transformation.indexparfonction')}}">Suivi de la transformation par fonction</a>
            <a class="dropdown-item" href="{{route('transformation.indexparstage')}}">Suivi de la transformation par stage</a>
          </div>
        </div>
        @endrole
        @if(auth()->user()->en_transformation)
        <div class="dropdown" >
          <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ma transformation
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('transformation.monlivret')}}">Mon livret</a>
            <a class="dropdown-item" href="{{route('transformation.mafichebilan')}}">Ma fiche bilan</a>
            <a class="dropdown-item" href="{{route('transformation.maprogression')}}">Ma progression</a>
          </div>
        </div>
        @endif
        
        <div class="dropdown" >
          <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Statistiques
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @can('statistiques.index')<a class="dropdown-item" href="{{route('statistiques.index')}}">Statistiques</a>@endcan
            @can('statistiques.pourtuteurs')<a class="dropdown-item" href="{{route('statistiques.pourtuteurs')}}">Bilan pour tuteurs</a>@endcan
            @can('statistiques.pour2ps')<a class="dropdown-item" href="{{route('statistiques.pour2ps')}}">Bilan pour 2PS</a>@endcan
            @can('statistiques.pourem')<a class="dropdown-item" href="{{route('statistiques.pourem')}}">Bilan pour EM</a>@endcan
            
          </div>
        </div>
        
        @endauth
      </ul>
      

      @auth
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ auth()->user()->displayString() }}
          </button>
          <div class="dropdown-menu" style="position:absolute;left:-90px" aria-labelledby="dropdownMenuButton">
          @if (count(auth()->user()->roles) > 1 )
            <a class="dropdown-item" href="{{ route('currentrole.show') }}">Changer de role</a>
          @endif
            <a class="dropdown-item" href="{{ route('changepasswd.show', auth()->user()->id) }}">Changer de mot de passe</a>
            <a class="dropdown-item" href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
          </div>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
        </div>
      @endguest
      </ul>
    </div>
  </div>
</nav>