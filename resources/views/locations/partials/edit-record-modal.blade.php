<form method="post" action="" class="p-6" id="edit_location_form">
    @csrf
    @method('patch')
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Where am I?')}}</h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{__("Enter daily where you are")}}</p>
    <div class="space-y-6 max-w-md">
        <div class="mt-6">
            <x-input-label for="edit_location" :value="__('Position')"/>
            <x-text-input id="edit_location" name="location" type="text" class="mt-1 block w-full" required
                          autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('location')"/>
        </div>

        <div>
            <x-input-label for="edit_date" :value="__('Date')"/>
            <div class="relative mt-1">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                              clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input id="edit_date" name="date" datepicker
                       type="text"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="{{__('Select date')}}">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('date')"/>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ml-3">
                {{ __('Update') }}
            </x-primary-button>
            <form id="delete_location_form">
                @csrf
                @method('DELETE')
                <x-danger-button class="ml-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </form>
        </div>
    </div>
</form>
