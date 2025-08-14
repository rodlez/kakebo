<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/balances" class="hover:text-red-600">Balances</a> /
        <a href="/balances/show/{{ $balance->id }}" class="font-bold text-black border-b-2 border-b-red-600">Info</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-orange-600">
            <span class="text-lg text-white px-4">Balance Info</span>
        </div>

        <!-- INFO -->
        <div class="mx-auto w-11/12 sm:w-4/5 mt-4 my-10 bg-gray-100 rounded-md shadow-sm">

            <div class="flex flex-row justify-between items-center py-4 sm:pb-8 sm:pt-0 sm:rounded-t-lg bg-black">
                <span class="text-xl text-white font-bold capitalize sm:mt-8 mx-4">Information</span>
                <div class="flex flex-row justify-end items-end gap-4 w-fit sm:mt-8 mx-2">
                    
                    <!-- Edit -->
                    <a href="{{ route('balances.edit', $balance) }}" title="Edit">
                        <i class="fa-solid fa-pencil text-white hover:text-blue-600 transition-all duration-500"></i>
                    </a>
                    <!-- Delete -->
                    <form action="{{ route('balances.destroy', $balance) }}" method="POST">
                        <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                        @csrf
                        <!-- Dirtective to Override the http method -->
                        @method('DELETE')
                        <button
                            onclick="return confirm('Are you sure you want to delete the balance: {{ $balance->title }}?')"
                            title="Delete">
                            <i
                                class="fa-solid fa-trash pr-4 text-white hover:text-red-600 transition-all duration-500"></i>
                        </button>
                    </form>
                </div>
            </div>
            <!-- User -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-circle-user w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">User</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $balance->user->name }} - {{ $balance->user->email }}</span>
            </div>
            <!-- Id -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 sm:border-t border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-fingerprint w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Id</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $balance->id }}</span>
            </div>                        
            <!-- Date -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-calendar-days w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Date</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $balance->date }}</span>
            </div>
            <!-- Name -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <!-- Clipboard Name Button-->
                <div class="flex flex-row justify-start items-center gap-2">
                    <span x-data="{ show: false }" class="relative" data-tooltip="Copy Name">
                        <button class="btn" data-clipboard-target="#name" x-on:click="show = true"
                            x-on:mouseout="show = false" title="Copy Name">
                            <i
                                class="fa-solid fa-pen-to-square w-6 text-center text-black hover:text-blue-600 transition-all duration-500"></i>
                        </button>
                        <span x-show="show" class="absolute -top-8 -right-6">
                            <span class="bg-orange-600 text-white rounded-lg p-2 opacity-100">Copied!</span>
                        </span>
                    </span>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Name</span>
                </div>
                <div id="name" class="w-full px-8 sm:px-2">{{ $balance->name }}</div>
            </div>            
            <!-- Total -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-clock w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Total</span>
                </div>
                <span
                    class="w-full px-8 sm:px-2">{{ $balance->total }} €</span>                
            </div>
            <!-- Source -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-route w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Source</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $balance->source }}</span>
            </div>                                    
            <!-- Info -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center sm:items-start pb-2 gap-2">
                    <i class="fa-solid fa-circle-info py-1 w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Info</span>
                </div>
                @if (strip_tags($balance->info) != '')
                    <div class="flex relative w-full">
                        <!-- Quill Editor -->
                        <div id="quill_editor"
                            class="w-full p-2 text-md rounded-lg bg-gray-200 border border-gray-300 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500 ">
                            {!! $balance->info !!}
                        </div>
                        <!-- Clipboard Info Button-->
                        <span x-data="{ show: false }" class="bg-white p-1 rounded-md absolute top-1 right-2"
                            data-tooltip="Copy Info">
                            <button class="btn" data-clipboard-target="#quill_editor" x-on:click="show = true"
                                x-on:mouseout="show = false">
                                <i class="fa-regular fa-clipboard"></i>
                            </button>
                            <span x-show="show" class="absolute top-1 right-6">
                                <span class="bg-orange-600 text-white rounded-lg p-1 opacity-100">Copied!</span>
                            </span>
                        </span>
                    </div>
                @else
                    <div class="w-full px-8 sm:px-2">-</div>
                @endif
            </div>

            
            <div class="bg-black py-4 sm:rounded-b-md">

            </div>


        </div>

    </div>

    <!-- To the Top Button -->
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa-solid fa-angle-up"></i></button>

    <!-- Footer -->
    <div class="py-4 flex flex-row justify-end items-center px-4 bg-orange-600 sm:rounded-b-lg">
        <a href="{{ route('balances.index') }}">
            <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                title="Go Back"></i>
        </a>
    </div>

</div>

</div>

<script>
    new ClipboardJS('.btn');
</script>
