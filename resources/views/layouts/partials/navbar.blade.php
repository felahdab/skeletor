@section('helplink')
  <x-help-link page="connexion"/>
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
                @can('annudef.index')<a class="dropdown-item" href="{{ route('annudef.index')}}">Annudef</a>@endcan
                @can('mails.index')<a class="dropdown-item" href="{{ route('mails.index')}}">Mails</a>@endcan
                @can('paramaccueils.index')<a class="dropdown-item" href="{{ route('paramaccueils.index')}}">Page d'accueil</a>@endcan
                @can('archives.index')<a class="dropdown-item" href="{{ route('archives.index')}}">Marins archivés</a>@endcan
                @php
                  $dashboard_url = \Filament\Pages\Dashboard::getUrl(panel: 'admin');
                @endphp
                <a class="dropdown-item" href="{{ $dashboard_url }}">Interface Filament</a>
              </div>
            </div>
            @endcan
          
            
            @endauth
        </ul>
      

      @auth

        
        <button type= "button" class='btn btn-outline-warning  me-2' data-bs-toggle="modal" data-bs-target="#bugreport-modal"> Signaler un problème</button> 
        
        <div id='notification-space' class="me-2"></div>

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
            <span class="dropdown-item">Skeletor {{env('APP_VERSION')}}</span>
          </div>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <span class="btn btn-outline-light me-2">@yield('helplink')</span>
          <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
        </div>
      @endguest
      
    </div>
  </div>
</nav>
