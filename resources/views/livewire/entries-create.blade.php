<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
{{request()->routeIs('entries.create')}}
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/entries" class="hover:text-orange-600">Entries</a> /
        <a href="/entries/create" class="font-bold text-black border-b-2 border-b-orange-600">Create</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-orange-600">
            <span class="text-lg text-white px-4">Create a New Entry</span>
        </div>

        <!-- New Entry -->
        <form wire:submit="save">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf

            <div class="mx-auto w-11/12">
                
                <!-- Type -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Type <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <i class="fa-solid fa-pen-to-square  bg-gray-200 p-3 rounded-l-md mr-6"></i>
                        <label>
                            Gasto
                            <input class="mr-4" type="radio" name="type" id="type" wire:model.live="type" 
                                value="0" {{ $this->type == 0 ? 'checked' : '' }}/>                                                                
                        </label>
                        <label>
                            Ingreso
                            <input type="radio" name="type" id="type" wire:model.live="type" 
                                value="1" {{ $this->type == 1 ? 'checked' : '' }}/>
                        </label>
                </div>
                <!-- Date -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Date <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="date" name="date" id="date" type="date" value="{{ old('date') }}"
                        maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-calendar-days bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('date')
                        {{ $message }}
                    @enderror
                </div>
                <!-- Title -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Title <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="title" name="title" id="title" type="text" value="{{ old('title') }}"
                        maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-pen-to-square bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('title')
                        {{ $message }}
                    @enderror
                </div>                
                <!-- Value -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Value <span class="text-xs">(€)</span> <span
                        class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="value" name="value" id="value" type="any" step=".01"
                        value="{{ old('value') }}" maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500">

                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-clock bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('value')
                        {{ $message }}
                    @enderror
                </div>
                <!-- Frequency -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Frequency <span class="text-red-600">*</span></h2>
                <div class="relative">
                    <select wire:model.live="frequency" name="frequency" id="frequency"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                        @foreach ($frequencies as $freq)
                            <option value="{{ $freq }}" class="text-orange-600"
                                @if (old('frequency') == $freq) selected @endif>{{ $freq }}</option>
                        @endforeach
                    </select>
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-basketball bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('frequency')
                        {{ $message }}
                    @enderror
                </div> 
                <!-- Company -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Company <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="company" name="company" id="company" type="text"
                        value="{{ old('company') }}" maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-location-dot bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('company')
                        {{ $message }}
                    @enderror
                </div>
                <!-- Category -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Category <span class="text-red-600">*</span></h2>
                <div class="relative">
                    <select wire:model.live="category_id" name="category_id" id="category_id"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" class="text-orange-600"
                                @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-basketball bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('category_id')
                        {{ $message }}
                    @enderror
                </div>   
                <!-- Balance -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Balance <span class="text-red-600">*</span></h2>
                <div class="relative">
                    <select wire:model.live="balance_id" name="balance_id" id="balance_id"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                        @foreach ($balances as $balance)
                            <option value="{{ $balance->id }}" class="text-orange-600"
                                @if (old('balance_id') == $balance->id) selected @endif>{{ $balance->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-basketball bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('balance_id')
                        {{ $message }}
                    @enderror
                </div>              
                <!-- Tags -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Tags <span class="text-red-600">*</span></h2>

                <div class="flex flex-row">

                    <div class="flex items-start inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-tags bg-gray-200 p-1 rounded-l-md"></i>
                    </div>

                    <div wire:ignore class="w-full">
                        <select wire:model="selectedTags" name="selectedTags" id="selectedTags" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" @if (old('selectedTags') == $tag->id) selected @endif>
                                    {{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('selectedTags')
                        {{ $message }}
                    @enderror
                </div> 
                <!-- Info -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Info</h2>
                <div class="flex">
                    <span><i class="bg-zinc-200 p-1 rounded-l-md fa-solid fa-circle-info"></i></span>
                    <div class="w-full">
                        @livewire('texteditor.quill')
                    </div>
                </div>
                <!-- Errors -->
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('info')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Save -->
                <div class="py-4 sm:pl-10">
                    <button type="submit"
                        class="w-full sm:w-60 bg-black hover:bg-slate-700 text-white uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out">
                        Save
                        <i class="fa-solid fa-floppy-disk px-2"></i>
                    </button>
                </div>

            </div>

        </form>

        <!-- To the Top Button -->
        <!-- <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                class="fa-solid fa-angle-up"></i></button> -->

        <!-- Footer -->
        <div class="py-4 flex flex-row justify-end items-center px-4 bg-orange-600 sm:rounded-b-lg">
            <a href="{{ route('entries.index') }}">
                <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                    title="Go Back"></i>
            </a>
        </div>

        @script()
            <script>
                $(document).ready(function() {
                    $('#selectedTags').select2();

                    // event
                    $('#selectedTags').on('change', function() {
                        let selected = $(this).val();
                        //console.log(selected);
                        //$wire.set('selectedTags', selected); -> equivalent to model.live, makes a request for each selection
                        //$wire.set('selectedTags', selected, false);     // only update when click, equivalent to model
                        $wire.selectedTags = selected; // same as $wire.set('selectedTags', selected, false);
                    });

                });                
            </script>
        @endscript

    </div>

</div>

