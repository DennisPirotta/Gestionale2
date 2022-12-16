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
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                                @if(request('user') == $user->id) selected @endif >{{ $user->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 relative">
                    @unless($data->count() === 0 || !request('month'))
                        <div class="overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 text-center">

                                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-2 px-4">
                                        #
                                    </th>
                                    @foreach($period as $day)
                                        <th scope="col"
                                            class="py-2 px-4 border-l border-gray-300 dark:border-gray-500">{{ $day->format('j') }}</th>
                                    @endforeach
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($data as $desc=>$type)

                                    <tr class="bg-gray-50 dark:bg-gray-500 dark:border-gray-800">
                                        <td class="py-2 px-4 dark:bg-gray-800 border-l">{{ $desc }}</td>
                                        <td colspan="{{$period->count()}}" class="py-2 px-4 dark:bg-gray-800"></td>
                                    </tr>
                                    @foreach($type as $key=>$content)
                                        @foreach($content as $job_type=>$hours)
                                            <tr class="bg-gray-100 dark:bg-gray-900 dark:border-gray-800 border-b">
                                                <th scope="row"
                                                    class="border-r dark:border-gray-700 p-1.5 grid grid-cols-1 place-items-center">
                                                    <div class="font-bold">
                                                        {{ $key !== 0 ? $key : '' }}
                                                    </div>

                                                    @if(Order::where('innerCode',$key)->exists())
                                                        <div>
                                                            {{ Order::where('innerCode',$key)->value('outerCode') }}
                                                        </div>
                                                        <div>
                                                            {{ Order::where('innerCode',$key)->first()->customer->name }}
                                                        </div>
                                                    @endif
                                                    @if(TechnicalReport::where('number',$key)->exists())
                                                        <div>
                                                            {{ TechnicalReport::where('number',$key)->first()->customer->name }}
                                                        </div>
                                                    @endif
                                                    @if(is_string($job_type))
                                                        <div class="w-15 dark:bg-blue-100 bg-blue-300 text-blue-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                            {{ $job_type }}
                                                        </div>
                                                    @endif
                                                </th>
                                                @foreach($period as $day)
                                                    <td class="border-r dark:border-gray-700"
                                                        data-datetime="{{ $day->format('Y-m-d') }}"
                                                        data-row="{{ $hour_types->where('description',$desc)->value('id') }}"
                                                        data-extra="{{ $key }}"
                                                        data-job="{{ $job_types->where('title',$job_type)->value('id') }}"
                                                        contenteditable="true"
                                                        @foreach($hours as $hour)
                                                            @if($hour->date === $day->format('Y-m-d'))
                                                                data-hour="{{ $hour->id }}">
                                                        {{ $hour->count }}
                                                        @endif
                                                        @endforeach
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                <h2>
                                    Nessuna ora disponibile al momento
                                </h2>
                        </div>
                    @endunless
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
    {{--    <x-flash-message></x-flash-message>--}}
    <script>
        $(() => {
            const token = $('meta[name="csrf-token"]').attr('content')
            let cells = $('td')
            cells.on('focusout', e => {
                let url = '{{ route('hours.store') }}'
                let method = 'POST'
                if ($(e.target).attr('data-hour')) {
                    url = '/hours/' + $(e.target).attr('data-hour')
                    if ($(e.target).text().trim() === '' || $(e.target).text().trim() === '0') method = 'DELETE'
                    else method = 'PUT'
                }
                const data = {
                    '_token': token,
                    '_method': method,
                    'count': $(e.target).text().trim(),
                    'date': $(e.target).attr('data-datetime'),
                    'description': null,
                    'hour_type_id': $(e.target).attr('data-row'),
                    'extra': $(e.target).attr('data-extra'),
                    'job': $(e.target).attr('data-job'),
                    'hour': $(e.target).attr('data-hour')
                };


                fetch(url, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token,
                    },
                    credentials: "same-origin",
                    body: JSON.stringify(data),
                })
            })
            cells.keypress(e => {
                if (e.which < 48 || e.which > 57) {
                    e.preventDefault();
                }
                if (e.keyCode === 13) {
                    e.preventDefault();
                    $(e.target).blur()
                }
            })
            $('#query input,select').change(() => {
                $('#query').submit()
            })
        })
    </script>
</x-app-layout>
