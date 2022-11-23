@php use Illuminate\Contracts\Auth\MustVerifyEmail; @endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Profile Information')}}</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{__("Update your account's profile information and email address.")}}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="image" :value="__('Image')"/>
            <img id="image-preview"
                 class="@if( !$user->image ) hidden @endif p-1 w-20 h-20 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                 src="{{ asset('storage/images/users/'.$user->image) }}" alt="{{ $user->name }} image"
                 style="margin-top: 10px">

            <div id="no-image"
                 class="@if( $user->image ) hidden @endif inline-flex overflow-hidden relative justify-center items-center w-20 h-20 bg-gray-100 rounded-full dark:bg-gray-600 ring-2 ring-gray-300 dark:ring-gray-500"
                 style="margin-top: 10px">
                <span class="font-medium text-gray-600 dark:text-gray-300">{{ $user->name[0] }}</span>
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
            <x-input-error class="mt-2" :messages="$errors->get('image')"/>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                          required autofocus autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $user->email)" required autocomplete="email"/>
            <x-input-error class="mt-2" :messages="$errors->get('email')"/>

            @if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        Your email address is unverified.

                        <button form="send-verification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                >{{__('Saved.')}}</p>
            @endif
        </div>
    </form>
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
</section>
