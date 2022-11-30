<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                            <x-tab-header :id="'all'"
                                          :controls="'all'"
                                          :icon="config('constants.orders.statuses.all.icon')"
                                          :content="'All'">
                            </x-tab-header>
                            @foreach($statuses as $status)
                                <x-tab-header :id="$status->description"
                                              :controls="$status->description"
                                              :icon="config('constants.orders.statuses.' . $status->description . '.icon')"
                                              :content="$status->description">
                                </x-tab-header>
                            @endforeach
                        </ul>
                        <div id="tabContentExample">
                            <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="all" role="tabpanel"
                                 aria-labelledby="all-tab">
                                <x-table-search-input :id="'all'"></x-table-search-input>
                                <table id="all-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Inner Code') }}
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Outer Code') }}
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Description') }}
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Customer') }}
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Action') }}
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders->sortBy('status') as $order)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $order->innerCode }}
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ $order->outerCode }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $order->description }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $order->customer->name }}
                                            </td>
                                            <td class="py-4 px-6">
                                                <span style="background-color: {{ config('constants.orders.statuses.'.$order->status->description.'.color') }}" class="text-gray-900 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $order->status->description }}</span>
                                            </td>
                                            <td class="py-4 px-6 flex">
                                                <a href="#"
                                                   class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <a href="#"
                                                   class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <script>
                                        $(document).ready(function () {
                                            $("#all-table-search").on("keyup", function () {
                                                let value = $(this).val().toLowerCase();
                                                $("#all-table tbody tr").filter(function () {
                                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                                });
                                            });
                                        });
                                    </script>
                                    </tbody>
                                </table>
                            </div>
                            @foreach($statuses as $status)
                                <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800"
                                     id="{{ preg_replace('/\s+/', '', $status->description) }}" role="tabpanel"
                                     aria-labelledby="{{ preg_replace('/\s+/', '', $status->description) }}-tab">
                                    @if($status->orders->isEmpty())
                                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                            {{ __('No orders with this status were found') }}
                                        </h2>
                                    @else
                                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                            <x-table-search-input
                                                    :id="preg_replace('/\s+/', '', $status->description)"></x-table-search-input>
                                            <table id="{{ preg_replace('/\s+/', '', $status->description) }}-table"
                                                   class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="py-3 px-6">
                                                        {{ __('Inner Code') }}
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        {{ __('Outer Code') }}
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        {{ __('Description') }}
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        {{ __('Customer') }}
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        {{ __('Action') }}
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($status->orders as $order)
                                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                        <th scope="row"
                                                            class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {{ $order->innerCode }}
                                                        </th>
                                                        <td class="py-4 px-6">
                                                            {{ $order->outerCode }}
                                                        </td>
                                                        <td class="py-4 px-6">
                                                            {{ $order->description }}
                                                        </td>
                                                        <td class="py-4 px-6">
                                                            {{ $order->customer->name }}
                                                        </td>
                                                        <td class="py-4 px-6 flex">
                                                            <a href="#"
                                                               class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                     viewBox="0 0 24 24"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          stroke-width="2"
                                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                </svg>
                                                            </a>
                                                            <a href="#"
                                                               class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                     viewBox="0 0 24 24"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          stroke-width="2"
                                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <script>
                                                $(document).ready(function () {
                                                    $("#{{ preg_replace('/\s+/', '', $status->description) }}-table-search").on("keyup", function () {
                                                        let value = $(this).val().toLowerCase();
                                                        $("#{{ preg_replace('/\s+/', '', $status->description) }}-table tbody tr").filter(function () {
                                                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                                        });
                                                    });
                                                });
                                            </script>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(() => {
            const statuses = @json($statuses, JSON_THROW_ON_ERROR);
            const tabElements = [{
                id: 'all',
                triggerEl: $(`#all-tab`)[0],
                targetEl: $(`#all`)[0]
            }]
            statuses.forEach(e => {
                tabElements.push({
                    id: e.description.replace(/\s/g, ''),
                    triggerEl: $(`#${e.description.replace(/\s/g, '')}-tab`)[0],
                    targetEl: $(`#${e.description.replace(/\s/g, '')}`)[0]
                })
            })
            const options = {
                defaultTabId: 'all',
                activeClasses: 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 border-blue-600 dark:border-blue-500',
                inactiveClasses: 'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
            }
            const tabs = new Tabs(tabElements, options);
            tabs.show('all')
        })
    </script>
</x-app-layout>