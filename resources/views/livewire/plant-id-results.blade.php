<div class="card bg-base-100 shadow-xl overflow-hidden">
    {{-- Result Image --}}
    <figure class="relative">
        <img src="{{ $images[$currentImageIndex]['imageUrl'] }}" alt="{{ $commonName }}" class="w-full h-64 object-cover" />

        {{-- Organ Badge --}}
        <div class="absolute top-3 left-3">
            <div class="badge badge-neutral badge-lg">
                {{ ucwords($images[$currentImageIndex]['organ']) }}
            </div>
        </div>

        {{-- Score Badge --}}
        <div class="absolute top-3 right-3">
            <div class="tooltip" data-tip="Confidence that this is the correct species">
                <div class="badge badge-{{ $this->colorOfScore }} badge-lg font-bold">
                    {{ $score }}%
                </div>
            </div>
        </div>

        {{-- Image Slider Overlay --}}
        @if (count($images) > 1)
            <div class="absolute inset-y-0 left-0 flex items-center">
                <button wire:click="back" class="btn btn-circle btn-sm btn-ghost bg-black/30 text-white ml-2 hover:bg-black/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center">
                <button wire:click="next" class="btn btn-circle btn-sm btn-ghost bg-black/30 text-white mr-2 hover:bg-black/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        @endif
    </figure>

    <div class="card-body">
        {{-- Species Name --}}
        <h3 class="card-title text-xl">{{ $commonName }}</h3>
        <p class="italic text-base-content/70">{{ $scientificNameWithout }}</p>

        {{-- Citation --}}
        <div class="text-xs text-base-content/50 mt-1">
            <p>{{ $images[$currentImageIndex]['citation'] }}</p>
            <p>{{ $images[$currentImageIndex]['date'] }}</p>
        </div>

        {{-- Progress bar for confidence --}}
        <div class="mt-2">
            <progress class="progress progress-{{ $this->colorOfScore }} w-full" value="{{ $score }}" max="100"></progress>
        </div>

        {{-- Actions --}}
        <div class="card-actions justify-end mt-3">
            <button wire:click="removeResult('{{ $resultId }}')" class="btn btn-error btn-sm btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Remove
            </button>
        </div>
    </div>
</div>
