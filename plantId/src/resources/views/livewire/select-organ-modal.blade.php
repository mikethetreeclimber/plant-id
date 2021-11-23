<x-dialog-modal wire:model="selectOrgan">
    <x-slot name="title">
        Select an Organ
    </x-slot>
    <x-slot name="content">

        <div class="w-full">
            <div class="mx-auto grid grid-cols-1">

                <x-image-card :img="$imageUrl" />

                    <div class="mt-2 w-full grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach ($organIcons as $organ)
                            <x-organ-select-button :organ="$organ" />
                        @endforeach
                    </div>
            </div>
        </div>
        <div class="mt-2">
            <x-button>
                Cancel and Remove
            </x-button>
        </div>
    </x-slot>

    {{-- <x-slot name="footer">
    </x-slot> --}}
</x-dialog-modal>
