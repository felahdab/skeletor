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
        </ul>
      
      
        <div class="text-end">
          <span class="btn btn-outline-light me-2">@yield('helplink')</span>
          @guest
          <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
          @endguest
        </div>
      
      
    </div>
  </div>
</nav>
