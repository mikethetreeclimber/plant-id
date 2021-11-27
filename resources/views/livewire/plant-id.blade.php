<x-container>
    <x-error on="hasErrors" :errors="$errors" />
    <div>
        <livewire:select-organ-modal />
    </div>
    <div wire:loading>
        <x-loading-gears />
    </div>

    <div>
        @if ($uploadingImages)
            <x-panel>
                <x-slot name="header">
                    <div class='flex items-center justify-center'>
                        <div class="w-full text-center">
                            <label
                                class="uppercase text-center text-sm md:text-lg text-gray-900 font-semibold mb-1">Upload
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
                <div class="grid gap-2 grid-cols-2">
                    @if (array_key_exists(0, $images) && array_key_exists(0, $organs))

                        <div class="mx-auto col-span-2 ">
                            <x-image-card :img="$images[$currentImageIndex]->temporaryUrl()"
                                :icon="$organs[$currentImageIndex]" />
                        </div>
                    @endif
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
                    <div class="flex justify-end space-x-2">
                        <button wire:click="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            type="button">
                            Submit
                        </button>
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
    <div>
        @isset($results)
            <div class="space-y-4">
                @foreach ($results as $key => $result)
                    @livewire('plant-id-results', ['result' => $result], key($key))
                @endforeach
            </div>
        @endisset
    </div>

</x-container>
