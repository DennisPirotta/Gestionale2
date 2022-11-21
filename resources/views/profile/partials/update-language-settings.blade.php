@php use Illuminate\Support\Facades\App; @endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Update Language Settings')}}</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{__('Set the display language of this site, note: the translation of the website has not yet been completed')}}</p>
    </header>
    <form method="post" action="{{ route('profile.updateLang') }}" class="mt-6 space-y-6">
        @csrf
        <ul class="grid gap-6 w-full md:grid-cols-2">
            <li>
                <input type="radio" id="italian" name="lang" value="it" class="hidden peer"
                       @if(App::getLocale() === 'it') checked @endif >
                <label for="italian"
                       class="inline-flex justify-between items-center p-5 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="block">
                        <div class="w-full text-lg font-semibold">{{ __('Italian') }}</div>
                    </div>
                    <img
                            src="https://flagcdn.com/24x18/it.png"
                            srcset="https://flagcdn.com/48x36/it.png 2x,https://flagcdn.com/72x54/it.png 3x"
                            width="24"
                            height="18"
                            alt="{{ __('Italian') }}"></label>
            </li>
            <li>
                <input type="radio" id="english" name="lang" value="en" class="hidden peer"
                       @if(App::getLocale() === 'en') checked @endif>
                <label for="english"
                       class="inline-flex justify-between items-center p-5 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="block">
                        <div class="w-full text-lg font-semibold">{{ __('English') }}</div>
                    </div>
                    <img
                            src="https://flagcdn.com/24x18/gb.png"
                            srcset="https://flagcdn.com/48x36/gb.png 2x,https://flagcdn.com/72x54/gb.png 3x"
                            width="24"
                            height="18"
                            alt="{{ __('English') }}">
                </label>
            </li>
        </ul>
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </form>
</section>