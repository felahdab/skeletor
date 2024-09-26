<!doctype html>
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