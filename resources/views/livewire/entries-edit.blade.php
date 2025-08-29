<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 p-2 text-sm text-slate-600">
        <a href="/entries" class="hover:text-black">Entries</a> /
        <a href="/entries/show/{{ $entry->id }}" class="hover:text-orange-600">Info</a> /
        <a href="/entries/edit/{{ $entry->id }}" class="font-bold text-black border-b-2 border-b-green-600">Edit</a>
    </div>

    <div class="bg-zinc-300 overflow-hidden shadow-sm sm:rounded-sm">

        <!-- Header -->
        <div class="flex flex-row p-2 bg-black">
            <span class="text-lg text-white border-b-2 border-b-green-600">Edit Entry</span>
        </div>

        <!-- Edit Entry -->
        <form wire:submit="save">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf

            <div class="mx-auto w-full py-2 md:p-2">
                               
                <!-- 1 row Type -->
                <div class="flex flex-col md:w-1/3 md:py-2">
                    
                    <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                        <span class="bg-black text-white p-2"><i class="fa-solid fa-pen-to-square"></i></span>
                        <h2 class="text-lg font-bold">Type <span class="text-red-600">*</span></h2>
                    </div>
                    
                    <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                        
                        <label>
                            Expense
                            <input type="radio" name="type" id="type" wire:model.live="type" class="accent-red-600" 
                                value="0" {{ $this->type == 0 ? 'checked' : '' }}/>                                                                
                        </label>
                        <label>
                            Income
                            <input type="radio" name="type" id="type" wire:model.live="type" class="accent-green-600" 
                                value="1" {{ $this->type == 1 ? 'checked' : '' }}/>
                        </label>
                        
                    </div>

                </div>

                <!-- 2 row Title and Company -->
                <div class="flex flex-col md:py-2">

                    <div class="flex flex-col md:flex-row justify-between w-full md:gap-2">
                        
                        <!-- Title -->
                        <div class="flex flex-col md:w-1/2">
                    
                            <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                                <span class="bg-black text-white p-2"><i class="fa-solid fa-pen"></i></span>
                                <h2 class="text-lg font-bold">Title <span class="text-red-600">*</span></h2>
                            </div>
                            
                            <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                            
                                <input wire:model="title" name="title" id="title" type="text" value="{{ old('title') }}"
                                    maxlength="200"
                                    class="w-full p-2 rounded-sm bg-gray-50 border border-gray-200 text-gray-900 focus:border-yellow-400 focus:outline-hidden dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                                
                            </div>

                            @error('title')
                                <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                                    {{ $message }}                                
                                </div>
                            @enderror

                        </div>
                    
                        <!-- Company -->
                        <div class="flex flex-col md:w-1/2">
                    
                            <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                                <span class="bg-black text-white p-2"><i class="fa-solid fa-industry"></i></span>
                                <h2 class="text-lg font-bold">Company <span class="text-red-600">*</span></h2>
                            </div>
                            
                            <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                            
                                <input wire:model="company" name="company" id="company" type="text"
                                    value="{{ old('company') }}" maxlength="200"
                                    class="w-full p-2 rounded-sm bg-gray-50 border border-gray-200 text-gray-900 focus:border-yellow-400 focus:outline-hidden">
                                
                            </div>

                            @error('company')
                                <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                                    {{ $message }}                                
                                </div>
                            @enderror

                        </div>
                        
                    </div>

                </div>

                <!-- 3 row Date, Value and Frequency -->
                <div class="flex flex-col md:py-2">

                    <div class="flex flex-col md:flex-row justify-between w-full">
                        
                        <!-- Date -->
                        <div class="flex flex-col md:w-1/3">
                    
                            <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                                <span class="bg-black text-white p-2"><i class="fa-solid fa-calendar-days"></i></span>
                                <h2 class="text-lg font-bold">Date <span class="text-red-600">*</span></h2>
                            </div>
                            
                            <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                            
                                <input wire:model="date" name="date" id="date" type="date" value="{{ old('date') }}"
                                    maxlength="200"
                                    class="w-full p-2 md:w-fit rounded-sm bg-gray-50 border border-gray-200 text-gray-900 focus:border-yellow-400 focus:outline-hidden dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                                
                            </div>

                            @error('date')
                                <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                                    {{ $message }}                                
                                </div>
                            @enderror

                        </div>

                        <!-- Value -->
                        <div class="flex flex-col md:w-1/3 md:px-2">
                    
                            <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                                <span class="bg-black text-white p-2"><i class="fa-solid fa-eur"></i></span>
                                <h2 class="text-lg font-bold">Value <span class="text-red-600">*</span></h2>
                            </div>
                            
                            <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                            
                                <input wire:model="value" name="value" id="value" type="any" step=".01"
                                    value="{{ old('value') }}" maxlength="200"
                                    class="w-full p-2 md:w-24 rounded-sm bg-gray-50 border border-gray-200 text-gray-900 focus:border-yellow-400 focus:outline-hidden">                                    
                                
                            </div>

                            @error('value')
                                <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                                    {{ $message }}                                
                                </div>
                            @enderror

                        </div>
                        
                        <!-- Frequency -->
                        <div class="flex flex-col md:w-1/3">
                    
                            <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                                <span class="bg-black text-white p-2"><i class="fa-solid fa-clock"></i></span>
                                <h2 class="text-lg font-bold">Frequency <span class="text-red-600">*</span></h2>
                            </div>
                            
                            <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                            
                                <select wire:model.live="frequency" name="frequency" id="frequency"
                                    class="w-full md:w-fit p-2.5 rounded-sm bg-gray-50 border border-gray-200 text-gray-900 focus:border-yellow-400 focus:outline-hidden dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                                    @foreach ($frequencies as $freq)
                                        <option value="{{ $freq }}" class="text-orange-600"
                                            @if (old('frequency') == $freq) selected @endif>{{ $freq }}</option>
                                    @endforeach
                                </select>
                                
                            </div>

                            @error('frequency')
                                <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                                    {{ $message }}                                
                                </div>
                            @enderror

                        </div>
                        
                    </div>

                </div>

                <!-- 3 row Company, Account and Category -->
                <div class="flex flex-col md:py-2">

                    <div class="flex flex-col md:flex-row justify-between w-full">
                        
                        <!-- Account -->
                        <div class="flex flex-col md:w-1/3">
                    
                            <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                                <span class="bg-black text-white p-2"><i class="fa-solid fa-piggy-bank"></i></span>
                                <h2 class="text-lg font-bold">Account <span class="text-red-600">*</span></h2>
                            </div>
                            
                            <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                            
                                <select wire:model.live="balance_id" name="balance_id" id="balance_id"
                                    class="w-full p-2.5 md:w-fit rounded-sm bg-gray-50 border border-gray-200 text-gray-900 focus:border-yellow-400 focus:outline-hidden dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                                    @foreach ($balances as $balance)
                                        <option value="{{ $balance->id }}" class="text-orange-600"
                                            @if (old('balance_id') == $balance->id) selected @endif>{{ $balance->name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>

                            @error('balance_id')
                                <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                                    {{ $message }}                                
                                </div>
                            @enderror

                        </div>
                        
                        <!-- Category -->
                        <div class="flex flex-col md:w-1/3 md:px-2">
                    
                            <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                                <span class="bg-black text-white p-2"><i class="fa-solid fa-tag"></i></span>
                                <h2 class="text-lg font-bold">Category <span class="text-red-600">*</span></h2>
                            </div>
                            
                            <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                            
                                <select wire:model.live="category_id" name="category_id" id="category_id"
                                    class="w-full p-2.5 md:w-fit rounded-sm bg-gray-50 border border-gray-200 text-gray-900 focus:border-yellow-400 focus:outline-hidden dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" class="text-orange-600"
                                            @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>

                            @error('category_id')
                                <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                                    {{ $message }}                                
                                </div>
                            @enderror

                        </div>

                        <!-- Tags -->
                        <div class="flex flex-col md:w-1/3">
                    
                            <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                                <span class="bg-black text-white p-2"><i class="fa-solid fa-tags"></i></span>
                                <h2 class="text-lg font-bold">Tags <span class="text-red-600">*</span></h2>
                            </div>
                            
                            <div class="flex flex-row justify-start items-center bg-zinc-200 px-2 py-4 gap-4">
                            
                                <div wire:ignore class="w-full">
                                    <select wire:model="selectedTags" name="selectedTags" id="selectedTags" multiple>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}" @if (old('selectedTags') == $tag->id) selected @endif>
                                                {{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>

                            @error('selectedTags')
                                <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                                    {{ $message }}                                
                                </div>
                            @enderror

                        </div>
                        
                    </div>

                </div>

                <!-- 1 row Info (optional) -->
                <div class="flex flex-col md:py-2">
                    
                    <div class="flex flex-row bg-green-600 text-white items-center gap-2">
                        <span class="bg-black text-white p-2"><i class="fa-solid fa-pen-to-square"></i></span>
                        <h2 class="text-lg font-bold">Info</h2>
                    </div>
                    
                    <div class="w-full p-2 bg-zinc-200">                        
                        @livewire('texteditor.quill', ['value' => $entry->info])                        
                    </div>

                    @error('info')
                        <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                            {{ $message }}                                
                        </div>
                    @enderror

                </div>

                <!-- 1 row Save -->
                <div class="flex flex-col md:w-1/3 md:py-2">
                    
                    <div class="flex flex-row bg-yellow-400 items-center gap-2">

                        <button type="submit"
                            class="w-full bg-black hover:bg-slate-700 text-white uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out">
                            Save
                            <i class="fa-solid fa-floppy-disk px-2"></i>
                        </button>
                        
                    </div>

                </div>
                

            </div>

        </form>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                class="fa-solid fa-angle-up"></i></button>

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-black rounded-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
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


