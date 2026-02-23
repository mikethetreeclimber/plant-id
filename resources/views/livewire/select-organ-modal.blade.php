<div>
    @if ($selectOrgan)
        <dialog class="modal modal-open" open>
            <div class="modal-box">
                <h3 class="text-lg font-bold mb-4">Select Plant Organ</h3>

                {{-- Image Preview --}}
                @if ($imageUrl)
                    <figure class="rounded-box overflow-hidden mb-4">
                        <img src="{{ $imageUrl }}" alt="Uploaded plant photo" class="w-full h-48 object-cover" />
                    </figure>
                @endif

                {{-- Organ Selection Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach ($organIcons as $organ)
                        <button wire:click="addSelectedOrgan('{{ $organ }}')" class="btn btn-outline btn-sm h-auto py-3 flex flex-col gap-1">
                            @switch($organ)
                                @case('bark')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                                    @break
                                @case('flower')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                                    @break
                                @case('fruit')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="14" r="7" stroke-width="2" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7V3m-2 4c0-2 2-4 2-4s2 2 2 4" /></svg>
                                    @break
                                @case('leaf')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66L12 14l-4 6c3-1 6-3 8-6s3-7 3-7-2 0-2 1z" /></svg>
                                    @break
                                @case('habit')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                    @break
                                @case('other')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @break
                            @endswitch
                            <span class="text-xs font-semibold">{{ ucwords($organ) }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="modal-action">
                    <button wire:click="$set('selectOrgan', false)" class="btn btn-ghost btn-sm">Cancel</button>
                </div>
            </div>
            <div class="modal-backdrop" wire:click="$set('selectOrgan', false)">
                <button>close</button>
            </div>
        </dialog>
    @endif
</div>
