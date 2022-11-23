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
    
    @include('layouts.partials.messages')

    @if (false)
    
        @include('layouts.partials.bugreport')
        <div class="container">
            <div class="row">
                <div class="col-sm-2 bg-light">
                    @include('layouts.partials.sidebar')
                </div>
                <div class="col-sm-10">
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        @include('layouts.partials.navbar')
        @include('layouts.partials.bugreport')
        <main class="container">
            @yield('content')
        </main>
        
    @endif
     
    @livewireScripts
    <script src="{!! asset('assets/js/alpine.js') !!}"></script>
    <script src="{!! asset('assets/js/jsfile.js') !!}"></script>
    <script src="{!! asset('assets/bootstrap/js/bootstrap.bundle.js') !!}"></script>
    @yield("scripts")

  </body>
</html>
