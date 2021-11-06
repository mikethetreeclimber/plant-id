<x-dialog-modal wire:model="selectOrgan">
    <x-slot name="title">
        Select an Organ
    </x-slot>
    <x-slot name="content">

        <div class="mx-auto p-4 w-full rounded-full space-x-8">
            <div class="mx-auto flex w-full rounded-full space-x-8">

                <div class="mx-auto flex w-full rounded-full space-x-8">

                    <img src="{{ $imageUrl}}" alt="plant id uploaded photo" class="max-w-full h-auto">
                </div>
                <div class="mx-auto flex w-full rounded-full space-x-8">
                    <ul role="list" class="space-y-3 w-full">
                        @foreach ($organIcons as $organ)
                            <li class="bg-white shadow overflow-hidden sm:rounded-md">
                                <button
                                    wire:click="addSelectedOrgan('{{ Str::before($organ, '.') }}')"
                                    type="button">
                                    <div class="flex items-center space-x-6 ml-3">
                                        <img src="{{ asset($organIconsPath . $organ) }}"
                                            alt="{{ Str::before($organ, '.') }} icon" class="w-10 h-10">
                                        <p>{{ ucwords(Str::before($organ, '.')) }}</p>
                                    </div>
                                </button>
                            </li>
                        @endforeach
                    </ul> 
                </div>
            </div>
    </x-slot>

    <x-slot name="footer">


        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
            <button type="button"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm"
                @click="open = false">
                Deactivate
            </button>
            <button type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm"
                @click="open = false">
                Cancel
            </button>
        </div>
    </x-slot>
    </div>
</x-dialog-modal>
