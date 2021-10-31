<x-container>
    <form wire:submit.prevent="makeRequest">
        <div>
            <x-tree-photo wire:model="images" />
            <x-error on="hasErrors" :errors="$errors" />
        </div>
        <div class="flex items-center justify-center m-2">

            <div class="grid grid-cols-2 lg:grid-cols-5">
                @foreach ($ids as $id)
                    <div class="m-2 pb-4">
                        <div class="grid grid-cols-1 mt-5 mx-7">
                            <div>
                                @if (!array_key_exists($id, $organs))
                                    <x-tree-organ wire:model="organs.{{ $id }}" wire:key="$id" />
                                @else
                                    <div class='flex items-center justify-center w-full'>
                                        <h4 class="text-base text-gray-800">{{ $organs[$id] }}</h4>
                                        <img src="{{ assets() }}" alt="">
                                    </div>
                                    <button type="button" wire:click="changeOrgan('{{ $id }}')"
                                        class="text-blue-900 text-xs underline">
                                        change
                                    </button>
                                @endif
                                @if (!array_key_exists($id, $images))

                                @else
                                    <div class='flex items-center justify-center w-full'>
                                        <img class="h-48 w-48" src="{{ $images[$id]->temporaryUrl() }}" alt="">
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
        <button
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            type="submit">
            Make Request
        </button>
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
    </form>
    @if ($results)
        <div class="space-y-4">

            @foreach ($results as $id => $result)
                @if ($id !== 'gbif')
                    <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
                        <div class="px-4 py-5 sm:px-6">
                            <x-tree-score :score="$result['score']" />
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">
                                {{ $result['species']['commonNames'][0] }}</h3>
                            <!-- Content goes here -->
                            <!-- We use less vertical padding on card headers on desktop than on body sections -->
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <!-- Content goes here -->
                            <div class="flex overflow-x-scroll space-x-2">
                                @for ($i = 0; $i < count($result['images']); $i++)
                                    <img class="w-52 h-52 flex-shrink-0 mx-auto"
                                        src="{{ $result['images'][$i]['url']['o'] }}" alt="">
                                @endfor
                            </div>
                        </div>
                        <div class="px-4 py-4 sm:px-6">
                            <!-- Content goes here -->
                            <!-- We use less vertical padding on card footers at all sizes than on headers or body sections -->\
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Title</dt>
                                <dd class="text-gray-500 text-sm">Paradigm Representative</dd>
                                <dt class="sr-only">Role</dt>
                                <dd class="mt-3">
                                    <span
                                        class="px-2 py-1 text-green-800 text-xs font-medium bg-green-100 rounded-full">Admin</span>
                                </dd>
                            </dl>
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
                                    <a href="tel:+1-202-555-0170"
                                        class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/phone -->
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        <span class="ml-3">Call</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</x-container>
