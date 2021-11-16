<x-container>
    <div>
        <x-error on="hasErrors" :errors="$errors" />
    </div>
    <livewire:select-organ-modal />

    <div>
        @if($uploadingImages)
            <x-panel>
                <x-slot name="header">
                    <div class='flex items-center justify-center'>
                        <div class="w-full text-center">
                            <label class="uppercase text-center text-sm md:text-lg text-gray-900 font-semibold mb-1">Upload
                                Photo</label>
                            <label
                                class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-400 bg-gray-500 border-gray-900 group'>
                                <div class='flex flex-col items-center justify-center pt-7'>
                                    <svg class="w-10 h-10 text-gray-900" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class='lowercase text-sm text-gray-900 pt-1 tracking-wider'>
                                        Select a photo</p>
                                </div>
                                <input wire:model="images" type='file' class="hidden" />
                            </label>
                        </div>
                    </div>
                </x-slot>
                {{-- Image Slider --}}
                <livewire:image-slider />
                
                <x-slot name="footer">
                    <div class="flex justify-end space-x-2">
                        <span>
                            <button wire:click="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                type="submit">
                                Submit
                            </button>
                            <div wire:loading wire:target="submit">
                                <x-loading-gears />
                            </div>
                        </span>
                        <button wire:click="clearProperties"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            type="button">
                            Clear Form
                        </button>
                    </div>
                </x-slot>
            </x-panel>
        @endif
    </div>
    {{-- Results --}}
    <div class="space-y-4">
        @isset($results)
            @foreach ($results as $id => $result)
                <x-panel>
                    <x-slot name="header">
                        <div class="flex justify-evenly">
                            <div>
                                <h2 class="mt-6 text-gray-900 text-sm font-extrabold">
                                    Score
                                </h2>
                                <h3 class="mt-2 mb-6 text-gray-900 text-sm font-medium">
                                    @php
                                        $score = number_format($result->score * 100, 1);
                                        if ($score > 50.0) {
                                            $colorOfScore = 'green';
                                        }
                                        if ($score < 50.0 && $score > 30.0) {
                                            $colorOfScore = 'yellow';
                                        }
                                        if ($score < 30.0) {
                                            $colorOfScore = 'red';
                                        }
                                    @endphp
                                    <span
                                        class="px-2 py-1 text-white text-xs font-medium bg-{{ $colorOfScore }}-600 rounded-full">
                                        {{ $score }}%
                                    </span>
                                </h3>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">
                                {{ $result->species->commonNames[0] }}</h3>
                        </div>
                    </x-slot>
                    <div class="grid gap-2 grid-cols-2">
                        {{-- @for ($i = 0; $i < count($result->images); $i++) --}}
                            <div class="mx-auto col-span-2 ">
                                {{-- @dump($result->images) --}}

                                <x-image-card img="{{ $result->images[0]->url->o }}"
                                    icon="{{ $result->images[0]->organ }}" />
                            </div>
                            <dl class="mt-1 flex-grow flex flex-col justify-between col-span-2">
                                <dt class="sr-only">Citation</dt>
                                <dd class="text-gray-800 text-sm">{{ $result->images[0]->citation }}</dd>
                                <dt class="sr-only">Date</dt>
                                <dd class="text-gray-800 text-sm">{{ $result->images[0]->date->string }}</dd>
                            </dl>
                        {{-- @endfor --}}
                        @if (count($result->images) > 1)
                            <div class="col-span-1 w-auto flex justify-center items-center">
                                <x-slider-button direction="back" />
                            </div>
                            <div class="col-span-1 w-auto flex justify-center items-center">
                                <x-slider-button direction="next" />
                            </div>
                        @endif
                    </div>
                    <x-slot name="footer">
                        <div class="-mt-px flex divide-x divide-gray-200">
                            <div class="w-0 flex-1 flex">
                                <a href="mailto:janecooper@example.com"
                                    class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-yellow-700 font-medium border border-transparent rounded-bl-lg hover:text-yellow-500">
                                    <!-- Heroicon name: solid/mail -->
                                    <svg class="w-5 h-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    <span class="ml-3">Not a match</span>
                                </a>
                            </div>
                            <div class="-ml-px w-0 flex-1 flex">
                                <button type="button"
                                    class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-green-900 font-medium border border-green-700 rounded-lg hover:text-green-500">
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
            @endforeach
        @endisset
    </div>
</x-container>
