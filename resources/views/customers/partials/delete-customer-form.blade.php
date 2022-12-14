@props(['customer'])
<x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-customer{{$customer->id}}-deletion')"
>{{__('Delete')}}</x-danger-button>
<x-modal name="confirm-customer{{$customer->id}}-deletion" focusable>
    <form method="post" action="{{ route('customers.destroy',$customer->id) }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Are you sure your want to delete this customer?')}}</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{__("Once this customer is deleted, all of its resources and data will be permanently deleted")}}</p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3">
                {{ __('Delete Customer') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>