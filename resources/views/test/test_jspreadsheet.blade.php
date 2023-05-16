@extends('layouts.app-master')

@section('content')
    <link href="{!! asset('assets/css/jspreadsheet.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/css/jspreadsheet.theme.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/css/jspreadsheet.datatables.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/css/jsuites.css') !!}" rel="stylesheet">

    <script src="{!! asset('assets/js/jspreadsheet.js') !!}"></script>
    <script src="{!! asset('assets/js/jsuites.js') !!}"></script>


    <div x-data='{}'>
        <div id="spreadsheet"></div>

        <script>
            var data = [
              ['Google', 1998, 807.80],
              ['Apple', 1976, 116.52],
              ['Yahoo', 1994, 38.66],
            ];
            
            jspreadsheet(document.getElementById('spreadsheet'), {
              data: data,
              colWidths: [ 300, 80, 100 ],
            });
        </script>
        
    </div>
        
@endsection

