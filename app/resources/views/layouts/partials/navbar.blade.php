<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#">Hidden brand</a>
      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/" class="nav-link px-2 text-white">Accueil</a></li>
        @auth
        @can('users.index')
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Stages
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('stages.index')}}">Stages</a>
          </div>
        </div>
        @endrole
        @hasrole('tuteur')
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Transformation
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('transformation.index')}}">Suivi de la transformation par marin</a>
            <a class="dropdown-item" href="{{route('transformation.indexparfonction')}}">Suivi de la transformation par fonction</a>
            <a class="dropdown-item" href="{{route('transformation.indexparstage')}}">Suivi de la transformation par stage</a>
          </div>
        </div>
        @endrole
        @if(auth()->user()->fonctions()->get()->count() != 0)
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ma transformation
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('transformation.fichebilan', auth()->user()->id )}}">Fiche bilan</a>
            <a class="dropdown-item" href="{{route('transformation.progression', auth()->user()->id )}}">Progression</a>
          </div>
        </div>
        @endif
        @can('statistiques.index')
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Statistiques
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Statistiques</a>
          </div>
        </div>
        @endcan
        @endauth
      </ul>
      

      @auth
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ auth()->user()->displayString() }}
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
    </div>
  </div>
</header>