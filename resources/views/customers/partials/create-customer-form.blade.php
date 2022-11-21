<section class="grid grid-cols-2 gap-4">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Create new customer')}}</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{__("Update your account's profile information and email address.")}}</p>
    </header>
    <form method="post" action="{{ route('customers.store') }}" enctype="multipart/form-data" class="mr-20">
        @csrf
        <x-input-label for="image" :value="__('Image')"/>
        <div id="image-preview" class="hidden">
            <img class="p-1 w-20 h-20 rounded-full ring-2 ring-gray-300 dark:ring-gray-500" alt="image" src="">
        </div>

        <div id="no-image"
             class="inline-flex overflow-hidden relative justify-center items-center w-20 h-20 bg-gray-100 rounded-full dark:bg-gray-600 ring-2 ring-gray-300 dark:ring-gray-500"
             style="margin-top: 10px">
            <span class="font-medium text-gray-600 dark:text-gray-300">N/A</span>
        </div>
        <input class="mt-3 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
               aria-describedby="file_input_help" id="image" type="file" accept="image/*" name="image">
        <p class="mt-1 ml-1 text-xs text-gray-500 dark:text-gray-400" id="file_input_help">SVG, PNG, JPEG or JPG
            only</p>
        <x-input-error class="mt-2" :messages="$errors->get('image')"/>

        <x-input-label class="mt-6" for="name" :value="__('Name')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus
                      autocomplete="name"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>

        <div class="flex items-center gap-4 mt-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
<script>
    $(() => {
        $('#image').change(e => {
            $('#image-preview').removeClass('hidden')
            $('#no-image').addClass('hidden')
            $('#image-preview img').attr('src', URL.createObjectURL(e.target.files[0]))
            console.log(URL.createObjectURL(e.target.files[0]))
        })
    })
</script>
