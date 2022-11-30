<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
<div id="calendar"></div>
<script>
    window.CreateCalendar = (events) => {
        const calendarEl = document.getElementById('calendar');
        const search = new URLSearchParams(window.location.search)
        const calendar = new Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
            headerToolbar: {
                left: 'title',
                center: '',
                right: 'changeView today prev next'
            },
            height: 700,
            locales: allLocales,
            locale: '{{ app()->getLocale() }}',
            initialView: 'dayGridMonth',
            selectable: true,
            events: @json($events, JSON_THROW_ON_ERROR),
            customButtons: {
                changeView: {
                    icon: '{{ request('user') ? config('icons.bootstrap.eye-off') : config('icons.bootstrap.eye') }}',
                    click: function (){
                        if(search.has('user'))
                            window.location.href = '/locations'
                        else
                            window.location.href = '/locations?user={{auth()->id()}}'
                    },
                    hint: '{{__('View only mine')}}'
                }
            },
            select: events.select,
            eventClick: events.eventClick
        })
        $(()=>{
            calendar.render();
        })
    }

</script>