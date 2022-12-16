@php use App\Models\Order;use App\Models\TechnicalReport;use App\Models\User;use Carbon\Carbon @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <span class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                {{ __('Hours') }}
                {{ request('user') !== null ? User::find(request('user'))->name : auth()->user()->name }}
                -
                {{ request('month') !== null ? Carbon::parse(request('month'))->translatedFormat('F Y') : __('Select a month') }}
            </span>

            <form class="ml-auto flex" id="query">
                <label>
                    <input type="month" id="month" name="month"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="{{__('Select date')}}" value="{{ request('month') }}">
                </label>
                <select id="users" name="user"
                        class="ml-2 w-44 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach(User::all() as $user)
                        <option value="{{ $user->id }}" @if(request('user') == $user->id) selected @endif >{{ $user->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <style>
        th, td{
            max-width: 15px !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        @if($order_hours->count() === 0 && $technical_report_hours->count() === 0 && $other_hours->count() === 0)
                            <h1 class="p-6 text-gray-900 dark:text-gray-100">Nessuna ora disponibile</h1>
                        @else
                            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-2 px-4">
                                        #
                                    </th>
                                    @foreach($period as $day)
                                        <th scope="col" class="border-l border-gray-300 dark:border-gray-500">{{ $day->translatedFormat('D') }}<br>{{ $day->translatedFormat('j') }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @include('hours.partial.order-table-section')
                                @include('hours.partial.technical-report-table-section')
                                @include('hours.partial.other-hours-table-section')
                                </tbody>
                            </table>
                        @endif
                    </div>
            </div>
        </div>
    </div>


    <iframe src="{{ action([\App\Http\Controllers\HourController::class,'print'],['user' => request('user'),'month' => request('month')]) }}" style="display: none" name="stampa"></iframe>
    <button onclick="frames['stampa'].print()">STAMPA</button>


    <x-speed-dial>
        <x-speed-dial-option :route="route('hours.create')" :icon="config('constants.icons.hours.new')"
                             :target="'new_hour'"/>
        <x-speed-dial-option :route="'javascript:window.print()'" :icon="config('constants.icons.printer')"
                             :target="'print'"/>
        <x-speed-dial-tooltip :message="__('New Hour')" :tooltip="'new_hour'"/>
        <x-speed-dial-tooltip :message="__('Print')" :tooltip="'print'"/>
    </x-speed-dial>

    <script>
        $(()=>{
            window.onbeforeunload = () => localStorage.setItem('scroll', window.scrollY)
            $(()=>{
                window.scrollTo(0,localStorage.getItem('scroll') ?? 0)
                $(document).click((e)=>{
                    $('div[data-popover]').not($('#'+$(e.target).attr('data-popover-target'))).each((i,e)=>{
                        $(e).removeClass('visible')
                        $(e).addClass('invisible')
                    })
                })
            })
        })

        $('td').focusout((e)=>{
            let count = $(e.target).clone().children().remove().end().text().trim()
            let child = $(e.target).children()
            let token = $('meta[name="csrf-token"]').attr('content')
            let headers = {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token,
            }
            if (child.length > 0){
                let id = child.text()
                if(count === '0' || count === ''){
                    fetch(`hours/${id}`,{
                        method: 'POST',
                        headers: headers,
                        credentials: "same-origin",
                        body: JSON.stringify({
                            '_method': 'DELETE',
                            '_token': token
                        })
                    }).then(()=>location.reload())
                }else{
                    fetch(`hours/${id}`,{
                        method: 'POST',
                        headers: headers,
                        credentials: "same-origin",
                        body: JSON.stringify({
                            'count': count,
                            '_method': 'PATCH',
                            '_token': token
                        })
                    }).then(()=>location.reload())
                }

            }else{
                fetch('{{ route('hours.store') }}',{
                    method: 'POST',
                    headers: headers,
                    credentials: "same-origin",
                    body: JSON.stringify({
                        'count': $(e.target).text().trim(),
                        'date': $(e.target).attr('data-date'),
                        'hour_type_id': $(e.target).attr('data-hour-type'),
                        '_token': token
                    })
                }).then((response) => response.json())
                    .then((hour) => {
                        if (hour.hour_type_id === '2'){
                            fetch('{{ route('technical-report-hours.store') }}',{
                                method: 'POST',
                                headers: headers,
                                credentials: "same-origin",
                                body: JSON.stringify({
                                    'hour_id': hour.id,
                                    'nightEU': false,
                                    'nightXEU': false,
                                    'technical_report_id': $(e.target).attr('data-technical-report-id'),
                                    '_token': token
                                })
                            }).then(()=>location.reload())
                        }else if (hour.hour_type_id === '1'){
                            fetch('{{ route('order-hours.store') }}',{
                                method: 'POST',
                                headers: headers,
                                credentials: "same-origin",
                                body: JSON.stringify({
                                    'signed': true,
                                    'order_id': $(e.target).attr('data-order-id'),
                                    'hour_id': hour.id,
                                    'job_type_id': 1,
                                    '_token': token
                                })
                            }).then(()=>location.reload())
                        }
                    });
            }
        }).keypress(e => {
            if (e.which < 48 || e.which > 57) {
                if(!(e.which == 44 || e.which == 46))
                    e.preventDefault();
            }
            if (e.keyCode === 13) {
                e.preventDefault();
                $(e.target).blur()
            }
        })
    </script>

</x-app-layout>
