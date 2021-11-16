<div>
    <div class="grid gap-2 grid-cols-2">
        @if (array_key_exists(0, $imageUrls) && array_key_exists(0, $organs))
            <div class="mx-auto col-span-2 ">
                <x-image-card :img="$imageUrls[$currentImageIndex]" :icon="$organs[$currentImageIndex]" />
            </div>
        @endif
        @if (count($imageUrls) > 1)
            <div class="col-span-1 w-auto flex justify-center items-center">
                <x-slider-button direction="back" />
            </div>
            <div class="col-span-1 w-auto flex justify-center items-center">
                <x-slider-button direction="next" />
            </div>
        @endif
    </div>
</div>
