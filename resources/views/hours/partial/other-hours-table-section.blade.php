@foreach($other_hours as $type=>$other_hour)
    <tr class="bg-gray-50 dark:bg-gray-500 dark:border-gray-800">
        <td class="py-2 px-4 dark:bg-gray-800 border-l">{{ __(\App\Models\HourType::find($type)->description) }}</td>
        <td colspan="{{$period->count()}}" class="py-2 px-4 dark:bg-gray-800"></td>
    </tr>
    <tr class="bg-gray-100 dark:bg-gray-900 dark:border-gray-800 border-b">
        <th scope="row" class="border-r dark:border-gray-700 p-1.5"></th>
        @foreach($period as $day)
            <td class="border-r dark:border-gray-700">
            @foreach($other_hour as $record)
                @if($record->date == $day->format('Y-m-d'))
                    {{ $record->count }}
                @endif
            @endforeach
            </td>
        @endforeach
    </tr>
@endforeach
