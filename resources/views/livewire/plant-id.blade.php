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
                <button wire:click="makeRequest"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    type="submit">
                    Make Request
                </button>
                <div wire:loading wire:target="makeRequest">
                    <!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!--
        Background overlay, show/hide based on modal state.
  
        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
  
      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
  
      <!--
        Modal panel, show/hide based on modal state.
  
        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <!-- Heroicon name: outline/exclamation -->
              <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                Deactivate account
              </h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            Deactivate
          </button>
          <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
                </div>
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
            @foreach ($results as $id => $result)
                {{-- @if ($id !== 'gbif') --}}
                    <x-panel>
                        <x-slot name="header">
                            <div class="flex justify-evenly">
                                <x-tree-score :score="$result['score']" />
                                <h3 class="mt-6 text-gray-900 text-sm font-medium">
                                    {{ $result['species']['commonNames'][0] }}</h3>
                            </div>
                        </x-slot>
                        <div class="flex overflow-x-scroll space-x-2">
                            @for ($i = 0; $i < count($result['images']); $i++)
                                <img class="w-52 h-52 flex-shrink-0 mx-auto"
                                    src="{{ $result['images'][$i]['url']['o'] }}" alt="">
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
