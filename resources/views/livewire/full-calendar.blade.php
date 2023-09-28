<div wire:ignore>
    <button wire:click="refreshCalendar">Rafraichir</button>
    <div id='calendar'></div>
</div>

@section('scripts')
    <script src="{!! asset('assets/js/fullcalendar_6.1.3.js') !!}"></script>
    <script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        locale: 'fr',
        
        initialView: 'resourceTimelineYear',
        nowIndicator : true,
        editable: true,
        droppable: true,

        eventAdd: info => @this.eventAdd(info.event),
        eventReceive: info => @this.eventReceive(info.event),
        eventRemove: info => @this.eventRemove(info.event),
        eventDrop: info => @this.eventDrop(info.event),
        eventClick: info => @this.eventClick(info.event),

        loading: function(isLoading) 
        {
            if (!isLoading)
            {
                this.getEvents().forEach(function(e)
                {
                    if (e.source ===null)
                    {
                        e.remove();
                    }
                })
            }
        },

        headerToolbar: {
            left: 'today prev,next',
            center: 'title',
            right: 'resourceTimelineDay,resourceTimelineTenDay,resourceTimelineMonth,resourceTimelineYear'
            },
        height: 650,
        weekNumbers: true,
        resourceGroupField: 'groupId',
        resources: function(fetchInfo, successCallback, failureCallback) 
            {
                @this.getResources().then(results => {
                    successCallback(results);
                })
            },
        
        events: function(fetchInfo, successCallback, failureCallback) 
        {
            @this.getEvents().then(results => {
                successCallback(results);
            })
        }
        });
        
        calendar.render();

        @this.on('refreshCalendar', function() {
            calendar.refetchEvents();
        })
    });

  </script>
@endsection