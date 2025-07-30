<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/tags" class="text-black hover:text-orange-600">Tags</a> /
        <a href="/tags/create" class="font-bold text-black border-b-2 border-b-orange-600">New</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <div>

            <!-- Header -->
            <div class="flex flex-row justify-between items-center py-4 bg-orange-400">
                <div>
                    <span class="text-lg text-white px-4">New Tag </span>
                </div>
                <div class="px-4">
                    <button wire:click.prevent="help">
                        <i class="fa-lg fa-solid fa-circle-question text-white hover:text-black transition duration-1000 ease-in-out" title="help"></i>
                    </button>
                </div>
            </div>
        
            <!-- Help -->
            @if ($show % 2 != 0)
                <div class="flex flex-row justify-start w-fit pt-4 px-4 sm:px-12">
                    <div class="bg-black text-sm text-white p-2 mx-2 rounded-lg relative">
                        <span class="text-orange-400 font-bold">HELP - </span> Add multiple tags using the Add button.
                        <button wire:click.prevent="help"><i class="fa-lg fa-solid fa-circle-xmark text-red-600 hover:text-red-400 transition duration-1000 ease-in-out absolute top-0 -right-2" title="Close"></i></button>
                    </div>
                </div>
            @endif
        
            <!--Tag -->
            <div class="mx-auto w-11/12 py-4 px-2">
                <div>
                    <span class="font-semibold pl-2">Add</span>
                    @if ($inputs->count() < 5)
                        <button wire:click.prevent="add">
                            <i class="fa-solid fa-circle-plus text-green-600 hover:text-green-400"></i>
                        </button>
                    @else
                        <span class="text-red-600 text-sm px-2">You have reached the limit (5)</span>
                    @endif
                </div>
                @php $count = 0 @endphp
                @foreach ($inputs as $key => $value)
                    <div class="flex flex-row justify-start items-center gap-2 py-2">
        
                        <input wire:model="inputs.{{ $key }}.name" type="text" id="inputs.{{ $key }}.name" class="w-full sm:w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 placeholder:text-zinc-400 px-2" placeholder="Enter a name">
                        @if ($count > 0)
                            <button wire:click="remove({{ $key }})">
                                <i class="fa-solid fa-trash text-red-600 hover:text-black transition duration-1000 ease-in-out" title="Delete"></i>
                            </button>
                        @else
                            <span class="px-4"></span>
                        @endif
                    </div>
                    @error('inputs.' . $key . '.name')
                        <div>
                            <span class="text-sm text-red-400 font-semibold px-2">{{ $message }}</span>
                        </div>
                    @enderror
                    @php $count++ @endphp
                @endforeach
                <div class="py-2">
                    <button wire:click.prevent="save" class="w-full sm:w-fit bg-black hover:bg-slate-700 text-white capitalize p-2 sm:px-4 rounded-lg shadow-none transition duration-500 ease-in-out {{ $inputs->count() > 5 ? 'cursor-not-allowed' : '' }}" {{ $inputs->count() > 5 ? 'disabled' : '' }}>
                        Save
                        <i class="fa-solid fa-floppy-disk px-2"></i>
                    </button>
                </div>
            </div>
        
            <!-- Footer -->
            <div class="flex flex-row justify-end items-center py-4 px-4 bg-orange-400 sm:rounded-b-lg">
                <a href="{{ route('tags.index') }}">
                    <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out" title="Go Back"></i>
                </a>
            </div>
        
        </div>

    </div>

</div>
