@if($order_hours->count() > 0)
    <tr class="bg-gray-50 dark:bg-gray-500 dark:border-gray-800">
        <td class="py-2 px-4 dark:bg-gray-800 border-l">{{__('Orders')}}</td>
        <td colspan="{{$period->count()}}" class="py-2 px-4 dark:bg-gray-800"></td>
    </tr>
    @foreach($order_hours as $order_hour)
        <tr class="bg-gray-100 dark:bg-gray-900 dark:border-gray-800 border-b">
            <th scope="row" class="border-r dark:border-gray-700 p-1.5">
                <h3 class="">{{ $order_hour->first()->order->innerCode }}</h3>
                <p>{{ $order_hour->first()->order->customer->name }}</p>
                <small>{{ $order_hour->first()->order->description }}</small>
            </th>
            @foreach($period as $day)
                <td class="border-r dark:border-gray-700">
                    <div    contenteditable="true"
                            data-order-id="{{ $order_hour->first()->order->id }}"
                            data-date="{{ $day->format('Y-m-d') }}"
                            data-hour-type="1"
                    >
                    @foreach($order_hour as $record)
                        @if($record->hour->date == $day->format('Y-m-d'))
                                {{ $record->hour->count }}
                                <data class="hidden">{{ $record->hour->id }}</data>
                            </div>
                            <div data-popover id="order-{{ $record->id }}" role="tooltip" class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{__('Edit Job Type')}}</h3>
                                </div>
                                <div class="px-3 py-2 relative">
                                    <form class="flex justify-center" action="{{ route('order-hours.update',$record) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input id="job_type_{{$record->id}}" name="job_type_id" class="hidden">
                                        @foreach(\App\Models\JobType::all() as $job_type)
                                            <button type="submit" onclick="$('#job_type_{{$record->id}}').val({{ $job_type->id }})" class="cursor-pointer mx-1 text-sm font-medium px-2.5 py-0.5 rounded {{ config('colors.job_types.'.$job_type->title) }}">{{ $job_type->title }}</button>
                                        @endforeach
                                    </form>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                            <div data-popover-target="order-{{ $record->id }}" data-popover-trigger="click" class="cursor-pointer mx-1 text-sm font-medium py-0.5 rounded {{ config('colors.job_types.'.$record->job_type->title) }} ">{{ $record->job_type->title }}</div>
                        @endif
                    @endforeach
                </td>
            @endforeach
        </tr>
    @endforeach
@endif

