<div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-col items-center py-10">
        @if($customer->image)
            <img class="p-1 w-20 h-20 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                 src="{{ asset('storage/images/customers/'.$customer->image) }}" alt="{{ $customer->name }} image">
        @else
            <div class="inline-flex overflow-hidden relative justify-center items-center w-20 h-20 bg-gray-100 rounded-full dark:bg-gray-600 ring-2 ring-gray-300 dark:ring-gray-500">
                <span class="font-medium text-gray-600 dark:text-gray-300">{{ $customer->name[0] }}</span>
            </div>
        @endif
        <h5 class="mt-1 text-xl font-medium text-gray-900 dark:text-white">{{ $customer->name }}</h5>
        <div class="flex mt-1 space-x-3 md:mt-2">
            <a href="{{ route('customers.edit',$customer->id) }}"
               class="uppercase inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Edit') }}</a>
            @include('customers.partials.delete-customer-form',['customer' => $customer])
        </div>
    </div>
</div>
