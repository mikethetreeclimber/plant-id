    <div class="bg-gray-400 overflow-hidden shadow rounded-lg w-full">
        <div class="px-4 pt-4 sm:px-6">
            {{ $header }}
        </div>
        <div class="px-4 sm:p-6">
            {{ $slot }}
        </div>
        @isset($footer)
            <div class="px-4">
                {{ $footer }}
            </div>
        @endisset
    </div>
