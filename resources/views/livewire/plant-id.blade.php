<x-app-layout>



    <div class="bg-gray-100">

        <div class="max-w-screen mx-auto py-6 sm:px-6 lg:px-8">

            <form wire:submit.prevent="save">


                <div class="flex items-center justify-center">
                    @if ($errors->hasAny(['images', 'organs']))

                    <div class="rounded-md bg-red-50 p-4 w-1/2">
                        <div class="flex items-center justify-center">
                            <div class="ml-3">
                                <div class="mt-2 text-sm text-red-700">
                                    <ul role="list" class="list-disc pl-5 space-y-1">
                                        @error('images')
                                        <li>
                                            {{ $message }}
                                        </li>
                                        @enderror
                                        @error('organs')
                                        <li>
                                            {{ $message }}
                                        </li>
                                        @enderror
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex items-center justify-center m-2">

                    <div class="grid grid-cols-2 lg:grid-cols-5">

                        @foreach ($ids as $id)
                        <div class="m-2 pb-4">
                            <div class="grid grid-cols-1 mt-5 mx-7">
                                <div>
                                    @if (!array_key_exists($id, $organs) || $errors->first('organs.'.$id))
                                    <x-plant-id.organ-select wire:model="organs.{{ $id }}" wire:key="$id"
                                    :error="$errors->first('organs.'.$id)" />

                                    @elseif(array_key_exists($id, $organs) )
                                    <div class='flex items-center justify-center w-full'>
                                        <h4 class="text-base text-gray-800">{{ $organs[$id] }}</h4>
                                    </div>
                                    <button
                                        type="button"
                                        wire:click="changeOrgan('{{ $id }}')"
                                        class="text-blue-900 text-xs underline">
                                        change
                                    </button>
                                    @endif

                                    


                                    @if (!array_key_exists($id, $images) || $errors->first('images.'.$id))

                                    <x-plant-id.photo wire:model="images.{{ $id }}" wire:key="$id"
                                        :error="$errors->first('images.'.$id)" />
                             
                                    @elseif(array_key_exists($id, $images))

                                    <div class='flex items-center justify-center w-full'>
                                        <img class="h-48 w-48" src="{{ $images[$id]->temporaryUrl() }}" alt="">
                                    </div>
                                    <button
                                        type="button"
                                        wire:click="changeImage('{{ $id }}')"
                                        class="text-blue-900 text-xs underline">
                                        change
                                    </button>

                                    @endif

                                </div>

                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>

                <button
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    type="submit">
                    Save Photo
                </button>
                <button
                wire:click="clearProperties"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                type="button">
                Clear Form
            </button>
            </form>

        </div>

    </div>



    {{--
    <div class="grid grid-cols-1 mt-5 mx-7">
    </div>
</div>
 --}}
</x-app-layout>