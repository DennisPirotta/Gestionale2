@php use Illuminate\Support\Facades\File; @endphp
<div id="toast-notification"
     class="absolute top-5 right-5 p-4 w-full max-w-xs text-gray-900 bg-white rounded-lg shadow dark:bg-gray-700 dark:text-gray-300"
     role="alert">
    <div class="flex items-center mb-3">
        <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white flex">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="ml-2">Impostazioni</span>
        </span>
    </div>
    <div class="flex items-center">
        <div class="inline-block relative shrink-0">
            @if($target->image)
                @if(File::exists(public_path('storage/images/customers/'.$target->image)))
                    <img class="p-1 w-12 h-12 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                         src="{{ asset('storage/images/customers/'.$target->image) }}" alt="{{ $target->name }} image">
                @else
                    <img class="p-1 w-12 h-12 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                         src="{{ session('image') }}" alt="{{ $target->name }} image">
                @endif
            @else
                <div class="inline-flex overflow-hidden relative justify-center items-center w-12 h-12 bg-gray-100 rounded-full dark:bg-gray-600 ring-2 ring-gray-300 dark:ring-gray-500">
                    <span class="font-medium text-gray-600 dark:text-gray-300">{{ $target->name[0] }}</span>
                </div>
            @endif
            <span class="inline-flex absolute right-0 bottom-0 justify-center items-center w-6 h-6 bg-blue-600 rounded-full">
                <svg aria-hidden="true" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                              d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"
                                                              clip-rule="evenodd"></path></svg>
                <span class="sr-only">Message icon</span>
            </span>
        </div>
        <div class="ml-3 text-sm font-normal">
            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $target->name }}</div>
            <div class="text-sm font-normal">{{ $message }}</div>
            <span class="text-xs font-medium text-blue-600 dark:text-blue-500">adesso</span>
        </div>
    </div>
</div>
<script>
    $(() => {
        $('#toast-notification').delay(3000).fadeOut()
    })
</script>