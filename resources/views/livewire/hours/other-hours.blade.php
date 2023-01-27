@php($count = 0)
@foreach($other_hours->groupBy('hour_type_id') as $type=>$other_hour)
    <tr class="bg-gray-50 dark:bg-gray-500 dark:border-gray-800">
        <td class="py-2 px-4 dark:bg-gray-800 border-l">{{ __(\App\Models\HourType::find($type)->description) }}</td>
        <td colspan="{{\Carbon\CarbonPeriod::create($start,$end)->count()}}" class="py-2 px-4 dark:bg-gray-800"></td>
    </tr>
    <tr class="bg-gray-100 dark:bg-gray-900 dark:border-gray-800 border-b">
        <th scope="row" class="border-r dark:border-gray-700 p-1.5"></th>
        @foreach(\Carbon\CarbonPeriod::create($start,$end) as $day)
            <td class="border-r dark:border-gray-700">
                @if($other_hour->contains(function ($item) use ($day){ return $item->date == $day->format('Y-m-d'); }))
                    @foreach($other_hour->where(function ($item) use ($day){ return $item->date == $day->format('Y-m-d'); }) as $hour)
                        <input class="w-full border-0 bg-gray-100" type="number" wire:focusout="saveHour()" wire:focus="selectHour({{ $hour->id }})" wire:model="other_hours.{{$other_hours->search($hour)}}.count">
                    @endforeach
                @else
                    @php($count++)
                    <div wire:key="empty-hour-{{ $count }}">
                        <input class="w-full border-0 bg-gray-100" type="number" name="count" wire:focus="selectEmptyHour({{ request('user',auth()->id()) }},'{{$day->format('Y-m-d')}}',{{$type}})"  wire:focusout="storeHour({{ $count }})" wire:model.defer="count.{{ $count }}">
                    </div>
                @endif
            </td>
        @endforeach
    </tr>
@endforeach
