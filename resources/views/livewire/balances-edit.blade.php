<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 py-1 text-sm text-slate-600">
        <a href="/balances" class="hover:text-black">Accounts</a> /
        <a href="/balances/show/{{ $balance->id }}" class="hover:text-amber-600">Info</a> /
        <a href="/balances/edit/{{ $balance->id }}" class="font-bold text-black border-b-2 border-b-green-600">Edit</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">

        <!-- Header -->
        <div class="flex flex-row text-white font-bold uppercase p-2 bg-green-600">
            <span>edit account</span>
        </div>

        <!-- Edit Balance -->
        <form wire:submit="save">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf

            <!-- INFO -->
            <div class="mx-auto w-11/12 mt-4 pb-4 rounded-sm flex flex-col gap-2">

                <!-- Id -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-fingerprint"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">id</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center w-full">
                        <span class="w-full p-2">{{$balance->id}}</span>
                    </div>

                </div>

                <!-- User -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-user"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">user</span>
                        </div>                    
                    </div>

                    <div class="flex flex-row justify-start items-center w-full">
                        <span 
                            class="w-full p-2">
                            {{ $balance->user->name }} / {{ $balance->user->email }}</span>
                    </div>

                </div>

                <!-- Date -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">date</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center p-0 w-full">
                        <input wire:model="date" name="date" id="date" type="date" value="{{ old('date') }}"
                                    maxlength="200"
                                    class="w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>

                </div>

                @error('date')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror 
                
                <!-- Name -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-pen"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">name</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center p-0 w-full">
                        <input wire:model="name" name="name" id="name" type="text" value="{{ old('title') }}"
                                    maxlength="200"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>

                @error('name')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

                <!-- Payment -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-money-bill"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">payment</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center w-full">
                        <select wire:model.live="source" name="source" id="source"
                            class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                            @foreach ($sources as $sou)
                                <option value="{{ $sou }}" class="text-orange-600"
                                    @if (old('source') == $sou) selected @endif>{{ $sou }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @error('source')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

                <!-- Total -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-eur"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">total</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center p-0 w-full">
                        <input wire:model="total" name="total" id="total" type="any" value="{{ old('total') }}"
                                    maxlength="20"
                                    class="w-full md:w-24 rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('total')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

                <!-- Info -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-info"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">extra information</span>
                        </div>                    
                    </div>
                    
                    <div class="w-full">
                        @livewire('texteditor.quill', ['value' => $balance->info])
                    </div>

                </div>

                @error('info')
                    <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                        {{ $message }}                                
                    </div>
                @enderror   

                <!-- Save -->
                <div class="flex flex-col md:items-end">
                    <button type="submit"
                        class="w-full md:w-1/4 bg-green-600 hover:bg-green-800 text-white font-semibold uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out cursor-pointer">
                        Save
                    </button>
                </div>

            </div>

        </form>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                class="fa-solid fa-angle-up"></i></button>

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-green-600 rounded-b-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>        

    </div>

</div>


