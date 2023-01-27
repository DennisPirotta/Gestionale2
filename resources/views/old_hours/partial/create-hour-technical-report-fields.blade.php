<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Technical Report Information')}}</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{__("Enter technical report information")}}</p>
    </header>
    <div class="mt-6 space-y-6" x-data="{new_fi:'null'}">
        <div>
            <x-input-label for="technical_report_id" :value="__('Technical Report')"/>
            <select :disabled="type !== '2'" x-model="new_fi" id="technical_report_id" name="extra" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="null">{{__('Choose a technical report')}}</option>
                <option value="new">{{__('New technical report')}}</option>
                @foreach($technical_reports as $technical_report)
                    <option value="{{ $technical_report->id }}" >({{ $technical_report->number }}) - {{ $technical_report->customer->name }} {{ $technical_report->secondary_customer !== null ? ' - '.$technical_report->secondary_customer->name : '' }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('extra')" class="mt-2"/>
        </div>

        <div x-show="new_fi != 'null'">
            <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Night') }}</span>
            <ul class="grid gap-6 w-full md:grid-cols-2">
                <li class="col-span-2">
                    <input :disabled="type !== '2'" type="radio" id="no-night" name="night" value="no-night" class="hidden peer" checked>
                    <label for="no-night" class="inline-flex justify-between items-center p-5 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <div class="block">
                            <div class="w-full text-lg font-semibold">{{__('No Night Spent')}}</div>
                        </div>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </label>
                </li>
                <li>
                    <input :disabled="type !== '2'" type="radio" id="eu" name="night" value="eu" class="hidden peer" required>
                    <label for="eu" class="inline-flex justify-between items-center p-5 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <div class="block">
                            <div class="w-full text-lg font-semibold">{{__('Night EU')}}</div>
                        </div>
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 130 130"><rect width="128" height="81.28" x="1" y="24.36" fill="#284999"/><polygon fill="#ffc943" points="68.12 36.81 65.13 36.38 63.79 33.67 62.46 36.38 59.47 36.81 61.63 38.92 61.12 41.9 63.79 40.49 66.47 41.9 65.96 38.92 68.12 36.81"/><polygon fill="#ffc943" points="68.12 88.43 65.13 88 63.79 85.29 62.46 88 59.47 88.43 61.63 90.54 61.12 93.52 63.79 92.11 66.47 93.52 65.96 90.54 68.12 88.43"/><polygon fill="#ffc943" points="91.8 67.44 91.34 64.46 93.53 62.39 90.56 61.91 89.27 59.18 87.88 61.86 84.89 62.24 87.01 64.39 86.45 67.35 89.15 66 91.8 67.44"/><polygon fill="#ffc943" points="40.17 67.45 39.72 64.46 41.92 62.39 38.94 61.91 37.65 59.18 36.27 61.86 33.27 62.24 35.4 64.39 34.83 67.35 37.53 65.99 40.17 67.45"/><polygon fill="#ffc943" points="81.85 41.15 78.85 40.81 77.42 38.15 76.18 40.9 73.21 41.44 75.44 43.47 75.03 46.46 77.65 44.97 80.37 46.28 79.76 43.33 81.85 41.15"/><polygon fill="#ffc943" points="54 83.89 51.01 83.45 49.68 80.75 48.34 83.45 45.35 83.88 47.51 85.99 47 88.97 49.67 87.56 52.34 88.97 51.83 86 54 83.89"/><polygon fill="#ffc943" points="87.64 80.16 87.04 77.2 89.14 75.03 86.14 74.68 84.72 72.02 83.47 74.77 80.5 75.29 82.72 77.33 82.3 80.32 84.93 78.83 87.64 80.16"/><polygon fill="#ffc943" points="43.7 54.28 43.22 51.3 45.4 49.21 42.41 48.75 41.1 46.03 39.74 48.73 36.75 49.13 38.89 51.26 38.36 54.23 41.04 52.85 43.7 54.28"/><polygon fill="#ffc943" points="73.42 88.76 76.06 87.3 78.76 88.66 78.19 85.69 80.32 83.54 77.32 83.17 75.93 80.48 74.65 83.22 71.67 83.71 73.87 85.77 73.42 88.76"/><polygon fill="#ffc943" points="47.31 44.75 50.04 43.45 52.65 44.96 52.26 41.97 54.51 39.95 51.54 39.4 50.32 36.64 48.87 39.29 45.87 39.6 47.94 41.8 47.31 44.75"/><polygon fill="#ffc943" points="89.16 55.21 88.69 52.23 90.88 50.15 87.9 49.68 86.59 46.96 85.22 49.65 82.23 50.04 84.37 52.18 83.82 55.15 86.51 53.78 89.16 55.21"/><polygon fill="#ffc943" points="43.69 79.47 43.27 76.48 45.5 74.44 42.52 73.92 41.27 71.17 39.85 73.84 36.85 74.18 38.95 76.35 38.35 79.31 41.07 77.99 43.69 79.47"/></svg>
                    </label>
                </li>
                <li>
                    <input :disabled="type !== '2'" type="radio" id="xeu" name="night" value="xeu" class="hidden peer">
                    <label for="xeu" class="inline-flex justify-between items-center p-5 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <div class="block">
                            <div class="w-full text-lg font-semibold">{{__('Night Extra EU')}}</div>
                        </div>
                        <svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </label>
                </li>
            </ul>
            <x-input-error class="mt-2" :messages="$errors->get('night')"/>
        </div>

        <div x-show="new_fi == 'new'">
            @include('hours.partial.create-technical-report-form')
        </div>
    </div>
</section>
