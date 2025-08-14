<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/balances" class="hover:text-yellow-600">Balances</a> /
        <a href="/balances/create" class="font-bold text-black border-b-2 border-b-yellow-600">Create</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-yellow-600">
            <span class="text-lg text-white px-4">Create a New Balance</span>
        </div>

        <!-- New Balance -->
        <form wire:submit="save">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf

            <div class="mx-auto w-11/12">

                <!-- Name -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Name <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="name" name="name" id="name" type="text" value="{{ old('name') }}"
                        maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-500 focus:border-yellow-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-pen-to-square bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <!-- Source -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Source <span class="text-red-600">*</span></h2>
                <div class="relative">
                    <select wire:model.live="source" name="source" id="source"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-500 focus:border-yellow-500">
                        @foreach ($sources as $sou)
                            <option value="{{ $sou }}" class="text-yellow-600"
                                @if (old('source') == $sou) selected @endif>{{ $sou }}</option>
                        @endforeach
                    </select>
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-basketball bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('source')
                        {{ $message }}
                    @enderror
                </div>
                <!-- Total -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Total <span class="text-xs">(€)</span> <span
                        class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="total" name="total" id="total" type="any" step=".01"
                        value="{{ old('total') }}" maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-500 focus:border-yellow-500">

                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-clock bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('total')
                        {{ $message }}
                    @enderror
                </div>                
                
                <!-- Date -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Date <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="date" name="date" id="date" type="date" value="{{ old('date') }}"
                        maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-500 focus:border-yellow-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-calendar-days bg-gray-200 p-1 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('date')
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
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                class="fa-solid fa-angle-up"></i></button>

        <!-- Footer -->
        <div class="py-4 flex flex-row justify-end items-center px-4 bg-yellow-600 sm:rounded-b-lg">
            <a href="{{ route('balances.index') }}">
                <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                    title="Go Back"></i>
            </a>
        </div>        

    </div>

</div>

