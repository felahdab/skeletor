@extends('layouts.app-master')

@section('content')
    <link href="{!! asset('assets/css/frappe-gantt.css') !!}" rel="stylesheet">
    <script src="{!! asset('assets/js/moment.js') !!}"></script>
    <script src="{!! asset('assets/js/snap.svg.js') !!}"></script>
    <script src="{!! asset('assets/js/frappe-gantt.js') !!}"></script>    
    <div x-data='{gantt:null}'>
        <svg id="gantt"></svg>

        <div class="btn-group mt-4 mb-4">
            <div class="btn btn-primary btn-sm" x-on:click="gantt.change_view_mode($el.innerHTML);">Quarter Day</div>
            <div class="btn btn-primary btn-sm" x-on:click="gantt.change_view_mode($el.innerHTML);">Half Day</div>
            <div class="btn btn-primary btn-sm" x-on:click="gantt.change_view_mode($el.innerHTML);">Day</div>
            <div class="btn btn-primary btn-sm" x-on:click="gantt.change_view_mode($el.innerHTML);">Week</div>
            <div class="btn btn-primary btn-sm" x-on:click="gantt.change_view_mode($el.innerHTML);">Month</div>
        </div>


        <div x-init="  
                tasks = [
                {
                id: 'Task 1',
                name: 'Premiere tache',
                start: '2023-05-01',
                end: '2023-05-05',
                progress: 20,
                dependencies: ''
                },
                {
                id: 'Task 2',
                name: 'Change process',
                start: '2023-05-02',
                end: '2023-05-04',
                progress: 20,
                dependencies: 'Task 1'
                },
                {
                id: 'Task 3',
                name: 'Change CSS framework',
                start: '2023-05-04',
                end: '2023-05-05',
                progress: 20,
                dependencies: 'Task 2'
                }
                ];
                gantt = new Gantt('#gantt', tasks);">
        </div>
    </div>
        
@endsection

