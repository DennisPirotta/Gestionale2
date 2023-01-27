@php use App\Models\Order;use App\Models\TechnicalReport;use App\Models\User;use Carbon\Carbon @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <span class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                {{ __('Hours') }}
                {{ request('user') !== null ? User::find(request('user'))->name . ' ' . User::find(request('user'))->surname : auth()->user()->name . ' ' . auth()->user()->surname }}
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
                        <option value="{{ $user->id }}" @if(request('user') == $user->id) selected @endif >{{ $user->name }} {{ $user->surname }}</option>
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
                        $(e).addClass('invisible opacity-0')
                        $(e).removeClass('visible opacity-100')
                    })
                })
            })
        })

        $('input').keypress(e => {
            console.log('click')
            if (e.which < 48 || e.which > 57) {
                if(!(e.which === 46))
                    e.preventDefault();
            }
            if (e.keyCode === 13) {
                e.preventDefault();
                $(e.target).blur()
            }
        })
    </script>

</x-app-layout>
