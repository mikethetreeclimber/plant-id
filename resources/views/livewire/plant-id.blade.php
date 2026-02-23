<div>
    {{-- Error Alert --}}
    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Organ Selection Modal --}}
    <livewire:select-organ-modal />

    {{-- Loading Spinner --}}
    <div wire:loading class="flex justify-center py-8">
        <span class="loading loading-bars loading-lg text-primary"></span>
    </div>

    {{-- Upload Section --}}
    @if ($uploadingImages)
        <div class="card bg-base-100 shadow-xl" wire:loading.remove>
            <div class="card-body">
                <h2 class="card-title justify-center text-lg">Upload Plant Photo</h2>

                {{-- File Upload Area --}}
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-base-content/30 rounded-box cursor-pointer hover:bg-base-200 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/50 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-base-content/60">Select a photo</p>
                    </div>
                    <input wire:model.live="images" type="file" class="hidden" accept="image/jpeg,image/png" />
                </label>

                {{-- Image Preview with Slider --}}
                @if (count($images) > 0 && count($organs) > 0 && array_key_exists($currentImageIndex, $images) && array_key_exists($currentImageIndex, $organs))
                    <div class="mt-4">
                        <div class="relative rounded-box overflow-hidden bg-base-300 mx-auto max-w-sm">
                            <img src="{{ $images[$currentImageIndex]->temporaryUrl() }}" alt="Uploaded plant photo" class="w-full h-64 object-cover rounded-box" />
                            <div class="absolute bottom-2 left-2">
                                <div class="badge badge-neutral badge-lg gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    {{ ucwords($organs[$currentImageIndex]) }}
                                </div>
                            </div>
                        </div>

                        {{-- Slider Controls --}}
                        @if (count($images) > 1)
                            <div class="flex justify-center gap-4 mt-3">
                                <button wire:click="back" class="btn btn-circle btn-sm btn-neutral">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <span class="flex items-center text-sm text-base-content/60">
                                    {{ $currentImageIndex + 1 }} / {{ count($images) }}
                                </span>
                                <button wire:click="next" class="btn btn-circle btn-sm btn-neutral">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="card-actions justify-end mt-4">
                    <button wire:click="clearProperties" class="btn btn-ghost">Clear</button>
                    <button wire:click="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Identify
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Results --}}
    @isset($results)
        <div class="space-y-4 mt-6">
            <h2 class="text-xl font-bold text-center">Identification Results</h2>
            @foreach ($results as $key => $result)
                <livewire:plant-id-results :result="$result" :key="$key" />
            @endforeach

            <div class="flex justify-center mt-4">
                <button wire:click="clearProperties" class="btn btn-outline btn-primary">
                    Start New Identification
                </button>
            </div>
        </div>
    @endisset
</div>
