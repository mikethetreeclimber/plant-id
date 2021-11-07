<x-container>
    {{-- <form wire:submit.prevent="makeRequest"> --}}
        <x-panel>
            {{-- <div> --}}
            {{-- <x-banner /> --}}
            {{-- </div> --}}



            <x-slot name="header">
                <div>

                    <x-tree-photo wire:model="images" />
                    <x-error on="hasErrors" :errors="$errors" />
                </div>

            </x-slot>

            <livewire:select-organ-modal />

            <div class="flex items-center justify-center">

                <div class="grid grid-cols-2 lg:grid-cols-5 space-x-8">
                    @foreach ($ids as $id)
                        <div>
                            <div class="grid grid-cols-1 mt-5">
                                <div>
                                    @if (array_key_exists($id, $organs))
                                        <div class='flex items-center justify-center w-full'>
                                            <img src="{{ asset('storage/icons/plant-id/organs/' . $organs[$id]) . '.png' }}"
                                                class="w-12 h-12" alt="{{ $organs[$id] }} icon">
                                        </div>
                                        <button type="button" wire:click="changeOrgan('{{ $id }}')"
                                            class="text-blue-900 text-xs underline">
                                            change
                                        </button>
                                    @endif
                                    @if (array_key_exists($id, $images))
                                        <div class='flex items-center justify-center w-full'>
                                            <img class="max-w-full h-auto" src="{{ $images[$id]->temporaryUrl() }}"
                                                alt="">
                                        </div>
                                        <button type="button" wire:click="changeImage('{{ $id }}')"
                                            class="text-blue-900 text-xs underline">
                                            change
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <x-slot name="footer">
                <span>
                    <button wire:click="makeRequest"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        type="submit">
                        Make Request
                    </button>
                    <div wire:loading wire:target="makeRequest">
                        Loading...
                    </div>
                </span>
                <button wire:click="clearProperties"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    type="button">
                    Clear Form
                </button>
                <button wire:click="getResponse"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    type="button">
                    Cached Response
                </button>

            </x-slot>
        </x-panel>
    {{-- </form> --}}

    <div>
        @isset($results)
        {{-- @dd($results) --}}
            @foreach ($results as $id => $result)
                {{-- @if ($id !== 'gbif') --}}
                    <x-panel>
                        <x-slot name="header">
                            <div class="flex justify-evenly">
                                <x-tree-score :score="$result->score" />
                                <h3 class="mt-6 text-gray-900 text-sm font-medium">
                                    {{ $result->species->commonNames[0] }}</h3>
                            </div>
                        </x-slot>
                        <div class="flex overflow-x-scroll space-x-2">
                            @for ($i = 0; $i < count($result->images); $i++)
                                <img class="w-52 h-52 flex-shrink-0 mx-auto"
                                    src="{{ $result->images[$i]->url->o }}" alt="">
                            @endfor
                        </div>
                        <dl class="mt-1 flex-grow flex flex-col justify-between">
                            <dt class="sr-only">Title</dt>
                            <dd class="text-gray-500 text-sm">Paradigm Representative</dd>
                            <dt class="sr-only">Role</dt>
                            <dd class="mt-3">
                                <span
                                    class="px-2 py-1 text-green-800 text-xs font-medium bg-green-100 rounded-full">Admin</span>
                            </dd>
                        </dl>
                        <x-slot name="footer">
                            <div class="-mt-px flex divide-x divide-gray-200">
                                <div class="w-0 flex-1 flex">
                                    <a href="mailto:janecooper@example.com"
                                        class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/mail -->
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <span class="ml-3">Email</span>
                                    </a>
                                </div>
                                <div class="-ml-px w-0 flex-1 flex">
                                    <button type="button"
                                        class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-green-600 font-medium border border-green-300 rounded-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/phone -->
                                        <svg viewBox="0 0 16 16" class="w-5 h-5 text-green-600" focusable="false"
                                            role="img" aria-label="check circle" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor">
                                            <g>
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
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
                {{-- @endif --}}
            @endforeach
        @endisset
    </div>
</x-container>
