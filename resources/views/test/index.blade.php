@extends('layouts.app-master')

@section('content')
    <div class="w-100">
        <div id='calendar'></div>
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('assets/js/fullcalendar_6.1.3.js') !!}"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        initialView: 'resourceTimelineYear',
        nowIndicator : true,
        headerToolbar: {
            left: 'today prev,next',
            center: 'title',
            right: 'resourceTimelineDay,resourceTimelineTenDay,resourceTimelineMonth,resourceTimelineYear'
            },
            height: 650,
            weekNumbers: true,
            resourceGroupField: 'groupId',
            resources: [
            {
            id: 'a',
            groupId: 'FDA',
            title: 'Chevalier Paul'
            },
            {
            id: 'b',
            groupId: 'FDA',
            title: 'Forbin'
            },
            {
            id: 'c',
            groupId: 'FLF',
            title: 'Courbet'
            }
        ],
        events: [
            {
            id: '1',
            resourceIds: ['a', 'b'],
            title: 'Formidable Shield 2023',
            start: '2023-09-28'
            }
        ]
            });
      calendar.render();
    });

  </script>
@endsection

            
