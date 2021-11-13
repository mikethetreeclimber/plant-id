@props(['organ'])
<div>
    <x-button wire:click="addSelectedOrgan('{{ $organ }}')">
            <div class="flex justify-evenly items-center w-full">
                <p class="text-white text-sm font-bold">{{ ucwords($organ) }}</p>
                @switch($organ)
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
                @case('habit')
                    <x-habitat-icon />
                @break
                @case('other')
                    <x-other-icon />
                @break
            @endswitch
            </div>
    </x-button>
</div>