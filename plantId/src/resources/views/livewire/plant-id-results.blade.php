<x-panel>
    <x-slot name="header">
        <div class="flex justify-evenly">
            <div>
                <h2 class="mt-6 text-gray-900 text-sm font-extrabold">
                    Score
                </h2>
                <h3 class="mt-2 mb-6 text-gray-900 text-sm font-medium">
                    <span
                        class="px-2 py-1 text-white text-xs font-medium bg-{{ $this->colorOfScore }}-600 rounded-full">
                        {{ $score }}%
                    </span>
                </h3>
            </div>
            <h3 class="mt-6 text-gray-900 text-lg font-medium">
                {{ $commonName }}</h3>
        </div>
    </x-slot>
    <div class="w-full">
        <button type="button" wire:click="compareUploadedToResult"
            class="relative w-full flex justify-center items-center flex-col text-sm text-indigo-700 font-medium border border-transparent rounded-bl-lg hover:text-indigo-500">
            <!-- Heroicon name: solid/mail -->
            <svg class="w-5 h-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor" aria-hidden="true">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
            <span>Compare</span>
        </button>
    </div>
    <div class="grid gap-2 grid-cols-2">
        <div class="mx-auto col-span-2 ">

            <x-image-card img="{{ $images[$currentImageIndex]['imageUrl'] }}"
                icon="{{ $images[$currentImageIndex]['organ'] }}" />
        </div>
        <dl class="mt-1 flex-grow flex flex-col justify-between col-span-2">
            <dt class="sr-only">Citation</dt>
            <dd class="text-gray-800 text-sm">{{ $images[$currentImageIndex]['citation'] }}</dd>
            <dt class="sr-only">Date</dt>
            <dd class="text-gray-800 text-sm">{{ $images[$currentImageIndex]['date'] }}</dd>
        </dl>
        @if (count($images) > 1)
            <div class="col-span-1 w-auto flex justify-center items-center">
                <x-slider-button direction="back" />
            </div>
            <div class="col-span-1 w-auto flex justify-center items-center">
                <x-slider-button direction="next" />
            </div>
        @endif
    </div>
    <x-slot name="footer">
        <div class="grid grid-cols-2">
            <div class="w-full col-span-1">
                <button type="button" wire:click="removeResult('{{ $resultId }}')"
                    class="relative w-full flex justify-center items-center flex-col  py-4 text-sm text-yellow-700 font-medium border border-transparent rounded-bl-lg hover:text-yellow-500">
                    <!-- Heroicon name: solid/mail -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-">Not a match</span>
                </button>
            </div>

            <div class="w-full col-span-1">
                <button type="button"
                    class="relative w-full flex justify-center items-center flex-col py-4 text-sm text-green-900 font-medium border border-green-700 rounded-lg hover:text-green-500">
                    <!-- Heroicon name: solid/phone -->
                    <svg viewBox="0 0 16 16" class="w-5 h-5 text-green-900" focusable="false" role="img"
                        aria-label="check circle" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <g>
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                            </path>
                            <path
                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z">
                            </path>
                        </g>
                    </svg>
                    <span class="ml-3">It's the right species</span>
                </button>
            </div>
        </div>
    </x-slot>
</x-panel>
