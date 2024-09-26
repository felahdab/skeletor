<!doctype html>
@if ( (Browser::browserFamily() == "Firefox" and Browser::browserVersionMajor() < 60) 
       or (Browser::browserFamily() == "Internet Explorer" and Browser::browserVersionMajor() <= 11)  )

    <html lang="en">
    <head>
    <title>{{ config('skeletor.instance_titre') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/images/favicon-32x32.png') !!}">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/images/favicon-16x16.png') !!}">
</head>
<body>
<div><center><h1>Bienvenue sur {{ config('skeletor.instance_titre') }} !</h1></center></div>
<div>
    <img src='{!! asset("assets/images/Logo_C2N.jpg") !!}' alt="Logo du C2N" style="height:450px; display: block; margin-left:auto; margin-right: auto; ">
</div>
<div>
<center>
Votre navigateur est trop ancien pour utiliser les fonctionnalités de {{ config('skeletor.instance_titre') }}.<p>
Veuillez le mettre à jour.<p>
Vous avez également la possibilité de télécharger directement une version portable de Firefox.<p>
<a href="{!! asset('FirefoxPortableUtilisateurPolarisOnline.zip') !!}">Firefox Portable</a>
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
    <title>{{ config('skeletor.instance_titre') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/images/favicon-32x32.png') !!}">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/images/favicon-16x16.png') !!}">

    @yield('before_styles')
    @stack('before_styles')
    @stack('styles')

    @stack('scripts')
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    
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
    
    @yield("scripts")
    
    @yield('after_scripts')
    @stack('after_scripts')

  </body>
</html>

@endif