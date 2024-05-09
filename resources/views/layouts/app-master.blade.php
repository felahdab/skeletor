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

    @yield('before_styles')
    @stack('before_styles')
    @vite(['../resources/js/app.js', '../resources/css/app.css'])

    @bassetArchive('https://github.com/SortableJS/Sortable/archive/refs/tags/1.15.1.zip', 'Sortable-1.15.1')
    @basset('Sortable-1.15.1/Sortable-1.15.1/Sortable.js')
    
    <style>
        [x-cloak] {
            display: none;
        }
    </style>
    @yield('styles')
    
    @yield('after_styles')
    @stack('after_styles')

</head>
<body>
    
    @include('layouts.partials.navbar')
    @include('layouts.partials.bugreport')
    @include('layouts.partials.notifications')
    
    
    <main class="container">
      @yield('before_breadcrumbs_widgets')
      @yield('after_breadcrumbs_widgets')
      @yield('header')

      @include('layouts.partials.messages')

      @yield('before_content_widgets')
      @if (isset($slot))
        {{ $slot }}
      @endif
      @yield('content')
      @yield('after_content_widgets')

    </main>
     
    @yield('before_scripts')
    @stack('before_scripts')
    
    
    <script src="{!! asset('vendor/livewire-charts/app.js') !!}"></script>
    
    <script src="{!! basset('https://cdn.jsdelivr.net/npm/apexcharts') !!}"></script>
    
    @yield("scripts")
    
    @yield('after_scripts')
    @stack('after_scripts')

  </body>
</html>

@endif