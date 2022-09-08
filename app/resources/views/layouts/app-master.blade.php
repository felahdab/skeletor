<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Contributors from the GTR/T">
    <title>FFAST</title>
	<link rel="icon" type="image/png" sizes="32x32" href="{!! url('assets/images/favicon-32x32.png') !!}">
	<link rel="icon" type="image/png" sizes="16x16" href="{!! url('assets/images/favicon-16x16.png') !!}">

    <!-- Bootstrap core CSS -->
    @livewireStyles
    <link href="{!! url('assets/css/feuilleDeStyle.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <script src="{!! url('assets/js/jscharts.js') !!}"></script>
    

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

</head>
<body>
    
    @include('layouts.partials.navbar')

    <main class="container">
        @yield('content')
    </main>
    
    @livewireScripts
    <script src="{!! url('assets/js/jsfile.js') !!}"></script>
    <script src="{!! url('assets/jquery/jquery-3.6.0.min.js') !!}"></script>
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.js') !!}"></script>
    @yield("scripts")
      
  </body>
</html>