<!doctype html>
@if ( (Browser::browserFamily() == "Firefox" and Browser::browserVersionMajor() < 60) 
       or (Browser::browserFamily() == "Internet Explorer" and Browser::browserVersionMajor() <= 11)  )

    <html lang="en">
    <head>
    <title>FFAST</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/images/favicon-32x32.png') !!}">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/images/favicon-16x16.png') !!}">
</head>
<body>
<div><center><h1>Bienvenue sur FFAST !</h1></center></div>
<div>
    <img src='{!! asset("assets/images/InsigneEscouade.jpg") !!}' alt="Logo de l'escouade" style="height:450px; display: block; margin-left:auto; margin-right: auto; ">
</div>
<div>
<center>
Votre navigateur est trop ancien pour utiliser les fonctionnalités de FFAST.<p>
Veuillez le mettre à jour.<p>
Vous avez également la possibilité de télécharger directement une version portable de Firefox vous permettant d'utiliser FFAST: <p>
<a href="{!! asset('assets/20221208_NP_GTR_Toulon_FirefoxPortable_pour_FFAST.zip') !!}">Firefox Portable</a>
</center>
</body>
</html>
@else


<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Contributors from the GTR/T">
    <title>FFAST</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/images/favicon-32x32.png') !!}">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/images/favicon-16x16.png') !!}">

    <!-- Bootstrap core CSS -->
    @livewireStyles
    <link href="{!! asset('assets/css/feuilleDeStyle.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/bootstrap/css/bootstrap.css') !!}" rel="stylesheet">
    <script src="{!! asset('assets/js/jscharts.js') !!}"></script>
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

</head>
<body>
    
    @include('layouts.partials.navbar')
    @include('layouts.partials.bugreport')
    
    <main class="container">
      @include('layouts.partials.messages')
      @if (isset($slot))
        {{ $slot }}
      @endif
      @yield('content')
    </main>
     
    @livewireScripts
    <script src="{!! asset('assets/bootstrap/js/bootstrap.bundle.js') !!}"></script>
    <script src="{!! asset('vendor/livewire-charts/app.js') !!}"></script>
    <script src="{!! asset('assets/js/alpine.js') !!}"></script>
    <script src="{!! asset('assets/js/jsfile.js') !!}"></script>
    <script src="{!! asset('assets/js/apexcharts.js') !!}"></script>
    
    @yield("scripts")

  </body>
</html>

@endif