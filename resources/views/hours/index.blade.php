<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <span class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                {{ __('Hours') }}
            </span>

            <div class="ml-auto">
                <form id="month-form">
                    <label>
                        <input type="month" id="month" name="month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('Select date')}}" value="{{ request('month') }}">
                    </label>
                </form>
            </div>

        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @unless($data->count() === 0 || !request('month'))
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 text-center">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-2 px-4">
                                        #
                                    </th>
                                    @foreach($period as $day)
                                        <th scope="col" class="py-2 px-4 border-l border-gray-500">{{ $day->format('j') }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $desc=>$type)
                                <tr class="bg-white dark:bg-gray-500 dark:border-gray-800">
                                    <td class="py-2 px-4 dark:bg-gray-800 border-l">{{ $desc }}</td>
                                </tr>
                                @foreach($type as $key=>$content)
                                    @foreach($content as $job_type=>$hours)
                                        <tr class="bg-white dark:bg-gray-900 dark:border-gray-800 border-b">
                                            <td class="border-r border-gray-700 p-1.5">
{{--                                                {{ $key !== 0 ? $key ?? '' : '' }}--}}
                                                {{ $key }}
                                                @if($job_type !== 0)
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                        {{ $job_type }}
                                                    </span>
                                                @endif
                                            </td>
                                            @foreach($period as $day)
                                                <td class="border-r border-gray-700" data-datetime="{{$day->format('Y-m-d')}}" data-row="{{$desc}}" data-extra="{{$key}}" data-job="{{$job_type}}" contenteditable="true"
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
{{--    <x-flash-message></x-flash-message>--}}
    <script>
        $(()=>{
            const token = $('meta[name="csrf-token"]').attr('content')
            let cells = $('td')
            cells.on('focusout',e=>{
                let url = '{{ route('hours.store') }}'
                let method = 'POST'
                if($(e.target).attr('data-hour')){
                    method = 'PUT'
                    url = '/hours/'+$(e.target).attr('data-hour')
                }

                const data = {
                    '_token': token,
                    '_method': method,
                    'count':  $(e.target).text().trim(),
                    'date': $(e.target).attr('data-datetime'),
                    'description' : null,
                    'hour_type_id': $(e.target).attr('data-row'),
                    'extra':  $(e.target).attr('data-extra'),
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
            cells.keypress( e => {
                if (e.which < 48 || e.which > 57)
                {
                    e.preventDefault();
                }
                if(e.keyCode === 13){
                    $(e.target).blur()
                }
            } )
            $('#month').change( e => {
                $('#month-form').submit()
            } )
        })
    </script>
</x-app-layout>