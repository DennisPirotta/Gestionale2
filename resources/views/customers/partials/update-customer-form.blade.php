<section class="grid grid-cols-2 gap-4">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Customer Information')}}</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{__("Update your account's profile information and email address.")}}</p>
    </header>
    <form method="post" action="{{ route('customers.update',$customer->id) }}" enctype="multipart/form-data"
          class="mr-20">
        @csrf
        @method('PATCH')
        <x-input-label for="image" :value="__('Image')"/>

        <img id="image-preview"
             class="@if( !$customer->image ) hidden @endif p-1 w-20 h-20 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
             src="{{ asset('storage/images/customers/'.$customer->image) }}" alt="{{ $customer->name }} image"
             style="margin-top: 10px">

        <div id="no-image"
             class="@if( $customer->image ) hidden @endif inline-flex overflow-hidden relative justify-center items-center w-20 h-20 bg-gray-100 rounded-full dark:bg-gray-600 ring-2 ring-gray-300 dark:ring-gray-500"
             style="margin-top: 10px">
            <span class="font-medium text-gray-600 dark:text-gray-300">{{ $customer->name[0] }}</span>
        </div>
        <div class="flex items-center mt-3">
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                   aria-describedby="file_input_help" id="image" type="file" accept="image/png, image/jpeg"
                   name="image">
            <button id="img-remove" data-tooltip-target="tooltip-default" type="button"
                    class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
            </button>
            <div id="tooltip-default" role="tooltip"
                 class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                {{ __('Remove image') }}
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
        <p class="mt-1 ml-1 text-xs text-gray-500 dark:text-gray-400" id="file_input_help">SVG, PNG, JPEG or JPG
            only</p>
        <x-input-error class="mt-2" :messages="$errors->get('image')"/>

        <x-input-label class="mt-6" for="name" :value="__('Name')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $customer->name)"
                      required autofocus autocomplete="name"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>

        <div class="flex items-center gap-4 mt-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
<script>
    $(() => {

        const preview = $('#image-preview')
        const empty = $('#no-image')

        $('#image').change(e => {
            preview.removeClass('hidden')
            empty.addClass('hidden')
            $('#image-preview').attr('src', URL.createObjectURL(e.target.files[0]))
        })

        $('#img-remove').click(e => {
            preview.attr('src', null)
            preview.addClass('hidden')
            $('#no-image').removeClass('hidden')
        })
    })
</script>
