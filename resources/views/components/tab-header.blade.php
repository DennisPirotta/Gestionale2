<li class="mr-2">
    <button id="{{preg_replace('/\s+/', '', $id)}}-tab" type="button" role="tab"
            aria-controls="{{ preg_replace('/\s+/', '', $controls) }}" aria-selected="false"
            class="inline-flex p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
        {!! $icon !!}
        {{ __($content) }}
    </button>
</li>