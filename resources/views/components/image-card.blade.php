@props([
    'img', 
    'icon' => null
    ])
<div
    class="overflow-hidden p-2 shadow-lg rounded-lg relative w-full h-auto m-auto bg-gray-900">

    <img alt="uploaded photo" src="{{ $img }}" class="rounded-lg w-full h-full object-fill" />


    <div class="absolute w-full p-2 bottom-1">
        @switch($icon)
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
    </div>

</div>
