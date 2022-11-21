@php use Illuminate\Support\Facades\Session; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Customers') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid md:grid-cols-3 grid-cols-1 gap-4 justify-items-center">
                    @forelse($customers as $customer)
                        <x-customer-card :customer="$customer"></x-customer-card>
                    @empty
                        <div class="md:col-span-3">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('No customers found') }}
                            </h2>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <x-speed-dial></x-speed-dial>
    @if(Session::has('message'))
        <x-flash-message :target="session('target')" :message="session('message')"></x-flash-message>
    @endif
</x-app-layout>