@if($technical_report_hours->count() > 0)
    <tr class="bg-gray-50 dark:bg-gray-500 dark:border-gray-800">
        <td class="py-2 px-4 dark:bg-gray-800 border-l">{{__('Technical Reports')}}</td>
        <td colspan="{{$period->count()}}" class="py-2 px-4 dark:bg-gray-800"></td>
    </tr>
    @foreach($technical_report_hours as $technical_report_hour)
        <tr class="bg-gray-100 dark:bg-gray-900 dark:border-gray-800 border-b">
            <th scope="row" class="border-r dark:border-gray-700 p-1.5">
                {{ $technical_report_hour->first()->technical_report->number }} <br>
                {{ $technical_report_hour->first()->technical_report->customer->name }}
            </th>
            @foreach($period as $day)
                <td class="border-r dark:border-gray-700">
                    <div    contenteditable="true"
                            data-technical-report-id="{{ $technical_report_hour->first()->technical_report->id }}"
                            data-date="{{ $day->format('Y-m-d') }}"
                            data-hour-type="2"
                    >
                        @foreach($technical_report_hour as $record)
                            @if($record->hour->date == $day->format('Y-m-d'))
                                    {{ $record->hour->count }}
                                    <data class="hidden">{{ $record->hour->id }}</data>
                                @if($record->nightEU)
                                </div>
                                <div data-popover-target="night-{{ $record->id }}" data-popover-trigger="click" class="cursor-pointer mx-1 bg-blue-100 text-blue-800 text-sm font-medium px-1 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                    EU
                                @elseif($record->nightXEU)
                                </div>
                                <div data-popover-target="night-{{ $record->id }}" data-popover-trigger="click" class="cursor-pointer mx-1 bg-green-100 text-green-800 text-sm font-medium px-1 py-0.5 rounded dark:bg-green-200 dark:text-green-900">
                                    XEU
                                @else
                                </div>
                                <div data-popover-target="night-{{ $record->id }}" data-popover-trigger="click" class="cursor-pointer mx-1 bg-yellow-100 text-yellow-800 text-sm font-medium px-1 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">
                                    NO
                                @endif
                                    <div data-popover id="night-{{ $record->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                        <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">{{__('Edit Night')}}</h3>
                                        </div>
                                        <div class="px-3 py-2">
                                            <form class="flex justify-center" action="{{ route('technical-report-hours.update',$record) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="technical_report_hour_id" value="{{ $record->id }}">
                                                <input type="hidden" id="night_eu_{{$record->id}}" name="night_eu">
                                                <input type="hidden" id="night_xeu_{{$record->id}}" name="night_xeu">
                                                <button type="submit" onclick="$('#night_eu_{{$record->id}}').val(1);$('#night_xeu_{{$record->id}}').val(0);" class="cursor-pointer mx-2 text-sm font-medium px-2.5 py-0.5 rounded bg-indigo-200 text-indigo-800">
                                                    EU
                                                </button>
                                                <button type="submit" onclick="$('#night_eu_{{$record->id}}').val(0);$('#night_xeu_{{$record->id}}').val(1);" class="cursor-pointer mx-2 text-sm font-medium px-2.5 py-0.5 rounded bg-green-200 text-green-900">
                                                    XEU
                                                </button>
                                                <button type="submit" onclick="$('#night_eu_{{$record->id}}').val(0);$('#night_xeu_{{$record->id}}').val(0);" class="cursor-pointer mx-2 text-sm font-medium px-2.5 py-0.5 rounded bg-yellow-200 text-yellow-900">
                                                    NO
                                                </button>
                                            </form>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>
                            @endif
                        @endforeach
                    </div>
                </td>
            @endforeach
        </tr>
    @endforeach
    <script>

    </script>
@endif
