<div>
    
    <div wire:ignore x-init="
        calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            locale: 'fr',
            
            initialView: 'resourceTimelineMonth',
            nowIndicator : true,
            editable: true,
            droppable: true,

            eventAdd: info => @this.eventAdd(info.event),
            eventReceive: info => @this.eventReceive(info.event),
            eventResize: info => @this.eventResize(info.event),
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
                right: 'resourceTimelineDay,resourceTimelineMonth,resourceTimelineYear'
                },
            height: 600,
            weekNumbers: true,
            //resourceGroupField: 'groupId',
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
            });">

        <button class='btn btn-primary mt-4 mb-4' wire:click="refreshCalendar">Rafraichir</button>
        <div id='calendar'></div>
    </div>
</div>
