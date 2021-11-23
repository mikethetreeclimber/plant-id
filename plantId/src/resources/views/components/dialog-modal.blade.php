@props(['modalId' => null, 'maxWidth' => null])

<x-modal :id="$modalId" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4 bg-gray-400 rounded-lg">
        <div class="text-lg text-center font-bold">
            {{ $title }}
        </div>

        <div class="mt-4">
            {{ $content }}
        </div>
    </div>
</x-modal>
