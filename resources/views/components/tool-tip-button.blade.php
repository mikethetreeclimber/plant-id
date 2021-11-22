
<div
x-data="
    {
        open: false
    }
"
class="relative"
>

    <!-- Trigger element -->
    <button 
    @mouseover="open = true" @mouseleave="open = false"
    class="bg-gray-400 text-gray-600 text-sm px-4 py-2 rounded hover:bg-gray-500 hover:text-gray-800 transition duration-150 shadow-sm">
        {{ $slot }}
    </button>

    <!-- Popover -->
    <!-- Make sure to add the requisite CSS for x-cloak: https://github.com/alpinejs/alpine#x-cloak -->

    <div 
    x-cloak
    x-show.transition="open"
    id="popover"
    class="p-3 space-y-1 max-w-xl bg-white rounded shadow-2xl flex flex-col text-sm text-gray-600 mt-3 absolute z-20">
        <strong class="text-sm text-gray-800 font-semibold">{{ $title }}</strong>
        <p>{{ $details }}</p>
    </div>
    
</div>

