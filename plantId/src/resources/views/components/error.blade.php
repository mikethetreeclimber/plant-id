@props([
    'on',
    'errors'
    ])

<div x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => {
        clearTimeout(timeout); shown = true; 
        timeout = setTimeout(() => { 
            shown = false }, 2000);  
        })"
    x-show.transition.out.opacity.duration.1500ms="shown" x-transition:leave.opacity.duration.1500ms
    style="display: none;" class="flex items-center justify-center">
    <div class="rounded-md p-2 w-5/6 bg-white">
        <div class="flex">
            <div class="flex justify-center items-center">
                <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 
                        3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 
                        2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 
                        13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <div class="mt-2">
                    <ul class="mt-3 list-disc list-inside text-sm text-red-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
