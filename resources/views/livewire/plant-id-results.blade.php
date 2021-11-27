<div class='flex max-w-sm w-full mx-auto'>
    <div class="overflow-hidden rounded-xl shadow-xl drop-shadow-xl relative">
        {{-- image overlay --}}
        <div
            class="absolute bottom-0 left-0 right-0 top-24 z-10 bg-gradient-to-t from-black via-gray-900 to-transparent">
        </div>

        {{-- species details --}}
        <div class="relative cursor-pointer group z-10 px-2 pt-10">
            <div class="align-self-end w-full">
                {{-- image slider btns --}}
                <div class="h-64 flex justify-between items-center w-full mb-8">
                    {{-- Back btn --}}
                    <div class="flex flex-col">
                        <button wire:click="back"
                            class="transition duration-500 ease-in-out -translate-y-1/2 w-11 h-11 flex justify-center items-center rounded-full z-10 bg-transparent hover:bg-gray-900">
                            <svg class=" w-8 h-8 font-bold transition duration-500 ease-in-out transform motion-reduce:transform-none text-white hover:text-gray-200 hover:-translate-x-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </button>
                    </div>
                    {{-- Next btn --}}
                    <div class="flex flex-col">
                        <button wire:click="next"
                            class="transition duration-500 ease-in-out translate-y-1/2 w-11 h-11 flex justify-center items-center bg-transparent hover:bg-gray-900 rounded-full z-10 ">
                            <svg class=" w-8 h-8 font-bold transition duration-500 ease-in-out transform motion-reduce:transform-none text-white hover:text-gray-200 hover:translate-x-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- citation /score /species name --}}
                <div class="flex flex-col mb-3 px-4 space-y-2">
                    {{-- citation --}}
                    <div class="text-gray-400 text-opacity-75 truncate flex flex-col justify-center items-center">
                        <span class="sr-only">Citation</span>
                        <p class="text-xs">{{ $images[$currentImageIndex]['citation'] }}</p>
                        <span class="sr-only">Date</span>
                        <p class=" text-xs">{{ $images[$currentImageIndex]['date'] }}</p>
                    </div>

                    {{-- Score --}}
                    <div class="flex justify-start items-center">
                        <div x-data="{open: false}" class="relative">
                            <button type="button" @mouseover="open = true" @mouseleave="open = false"
                                class="text-right px-3 py-2 text-white text-sm font-medium bg-{{ $this->colorOfScore }}-600 rounded-full">
                                {{ $score }}%
                            </button>
                            <div x-show.transition.out.opacity.duration.1500ms="open"
                                x-transition:leave.opacity.duration.1500ms
                                class="p-3 transition  ease-in-out rounded shadow-2xl flex flex-col left-0 max-w-xl bg-white text-sm text-gray-800 mt-3 absolute z-20 w-64">
                                <p class="font-bold">
                                    Probability this is the correct species
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Species Name --}}
                    <div>
                        <h3 class="text-2xl font-bold text-white">{{ $commonName }}</h3>
                        <p class="max-w-4xl italic text-lg text-gray-300">{{ $scientificNameWithout }}</p>
                    </div>
                </div>

                {{-- description / wiki link --}}
                <div class="flex flex-col px-4">
                    <div class="text-base text-gray-400 mb-2">Description:</div>
                    <p class="text-xs text-gray-100 mb-6">
                        Wiki Link
                        Paul Atreides, a brilliant and gifted young man born into a great destiny
                        beyond his understanding, must travel to the most dangerous
                    </p>
                </div>
            </div>

            {{-- Top btn overlays image --}}
            <div class="absolute inset-x-0 top-0 pt-3 pl-3 w-full mx-auto flex justify-start items-center">
                <button type="button" wire:click="compare"
                    class="relative flex items-center w-min  flex-shrink-0 p-2 text-center text-white ">
                    @switch($images[$currentImageIndex]['organ'])
                        @case('bark')
                            <x-bark-icon />
                        @break
                        @case('leaf')
                            <x-leaf-icon />
                        @break
                        @case('flower')
                            <x-flower-icon />
                        @break
                        @case('fruit')
                            <x-fruit-icon />
                        @break
                        @case('habitat')
                            <x-habitat-icon />
                        @break
                        @case('other')
                            <x-other-icon />
                        @break
                        @default
                    @endswitch
                    <div
                        class="absolute flex space-x-2 transition opacity-0 px-4 py-2 rounded-xl duration-500 ease-in-out transform group-hover:opacity-100 group-hover:translate-x-20 text-xl font-bold text-white bg-gray-900 bg-opacity-90 group-hover:pr-8">
                        <i class="fas fa-question-circle text-2xl"></i>
                        <p>Compare</p>
                    </div>
                </button>
            </div>
        </div>

        {{-- image --}}
        <img class="absolute inset-0 transform w-full" src="{{ $images[$currentImageIndex]['imageUrl'] }}"
            style="filter: grayscale(0);" />

        {{-- footer --}}
        <div class="flex justify-evenly relative pb-10 space-x-1 z-10">
            <button type="button" wire:click="confirm"
                class="flex items-center py-2 px-4 rounded-full text-white bg-green-500 hover:bg-green-700">
                <i class="fas fa-check"></i>
                <div class="text-sm text-white ml-2">Confirm</div>
            </button>
            <button type="button" wire:click="removeResult('{{ $resultId }}')"
                class="flex items-center py-2 px-4 rounded-full text-white bg-red-500 hover:bg-red-700">
                <i class="far fa-trash text-2xl"></i>
                <div class="text-sm text-white ml-2">Remove</div>
            </button>
        </div>
    </div>
</div>
