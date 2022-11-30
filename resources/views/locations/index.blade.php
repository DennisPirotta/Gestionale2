<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Where am I') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-12 sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('locations.partials.calendar')
            </div>
        </div>
    </div>
    <x-modal name="add_record">
        @include('locations.partials.add-record-modal')
    </x-modal>
    <x-modal name="edit_record">
        @include('locations.partials.edit-record-modal')
    </x-modal>

    <script>
        $(() => {
            let options = {
                format: "yyyy-mm-dd",
                autohide: true,
                todayBtn: true,
                clearBtn: true,
                todayBtnMode: 1,
            }
            let add_date = document.getElementById('add_date')
            let add_datepicker = new Datepicker(add_date, options)
            let edit_date = document.getElementById('edit_date')
            let edit_datepicker = new Datepicker(edit_date, options)
            let calendarEvents = {
                select: function (info) {
                    info.jsEvent.target.dispatchEvent(new CustomEvent('open-modal', {
                        detail: 'add_record',
                        bubbles: true
                    }))
                    add_datepicker.setDate(info.startStr)
                },
                eventClick: function (info) {
                    info.jsEvent.target.dispatchEvent(new CustomEvent('open-modal', {
                        detail: 'edit_record',
                        bubbles: true
                    }))
                    edit_datepicker.setDate(info.event.startStr)
                    $('#edit_location').val(info.event.extendedProps.content)
                    $('#edit_location_form').attr('action',`/locations/${info.event.id}`)
                    $('#delete_location_form').attr('action',`/locations/${info.event.id}`)
                },
            }
            CreateCalendar(calendarEvents)
        })
    </script>

</x-app-layout>