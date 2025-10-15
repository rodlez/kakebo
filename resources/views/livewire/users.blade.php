<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-col bg-green-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('message') }}</span>
                <a href="/users/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex flex-col bg-red-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('error') }}</span>
                <a href="/users/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-row justify-between items-center gap-2 p-2 font-bold uppercase bg-green-600 text-white rounded-sm">
        
        <div>
            <a href="/users" class="border-b-2 border-b-white">Users</a> 
        </div>
    </div>


    <div class="overflow-hidden py-2 bg-zinc-200">

        <!-- FILTERS-->
        <div class="flex flex-col bg-green-800 mx-auto">

            <div class="flex flex-row justify-between items-center w-full text-white">
                <span class="capitalize text-lg px-2">
                    <a wire:click="activateFilter" class="cursor-pointer" title="{{($showFilters % 2 != 0) ? 'Close Filters' : 'Open Filters'}}">filters</a>
                </span>
                <!-- Open/Close Buttons -->
                <div class="p-2">
                    @if ($showFilters % 2 != 0)
                        <a wire:click="activateFilter" class="cursor-pointer" title="Close Filters">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @else
                        <a wire:click="activateFilter" class="cursor-pointer" title="Open Filters">
                            <i class="fa-solid fa-caret-down"></i>
                        </a>
                    @endif
                </div>
            </div>

            @if ($showFilters % 2 != 0) 
            <!-- Filters Options -->    
            <div class="flex flex-col bg-zinc-200 opacity-95 py-2">

                <!-- 2 ROW FILTER -->

                <div class="flex flex-col md:flex-row p-1 my-1">
                    <!-- USERS -->
                    <div class="flex flex-row justify-between md:w-1/2 w-full">                    
                    
                        <div class="w-5/12 px-1">
                            <span><i class="fa fa-user"></i></span>
                            <span class="px-0">Users <span
                                    class="text-xs">({{ $users->count() }})</span></span>                            
                        </div>                        
                        <div class="flex flex-row w-6/12 justify-end">                            
                            <select wire:model.live="isAdmin" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                <option value="2">All</option>
                                <option value="0">Users</option>
                                <option value="1">Admins</option>
                            </select>
                                                        
                        </div>
                        <div class="w-1/12">
                            @if ($isAdmin != 2)
                                <a wire:click.prevent="clearFilterIsAdmin" title="Reset Filter User" class="cursor-pointer">
                                    <span class="text-red-400 hover:text-red-600 px-1 justify-center items-center"><i
                                            class="fa-solid fa-circle-xmark"></i></span>
                                </a>
                            @endif
                        </div>

                    </div>

                </div>

                <!-- 2 ROW FILTER DATE-->
                <div class="flex flex-col md:flex-row p-1 my-1">
                    <!-- Date From -->
                    <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                        
                        <div class="w-5/12 px-1">
                            <span><i class="fa fa-calendar"></i></span>
                            <span>Date <span class="text-sm font-bold">from</span></span>                            
                        </div>                        
                        <div class="flex flex-row w-6/12 justify-end">                            
                            <input type="date" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer" placeholder="From"
                                wire:model.live="dateFrom">                                                                                            
                        </div>
                        <div class="w-1/12">
                            @if ($initialDateFrom != $dateFrom)
                                <a wire:click.prevent="clearFilterDate" title="Reset Filter Date from" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </span>
                                </a>
                            @endif
                        </div>

                    </div>

                    <!-- Date To -->
                    <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                        
                        <div class="w-5/12 px-1">
                            <span><i class="fa fa-calendar"></i></span>
                            <span>Date <span class="text-sm font-bold">to</span></span>                            
                        </div>                        
                        <div class="flex flex-row w-6/12 justify-end">                            
                            <input type="date" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer" placeholder="From"
                                wire:model.live="dateTo">                                                                                            
                        </div>
                        <div class="w-1/12">
                            @if ($initialDateTo != $dateTo)
                                <a wire:click.prevent="clearFilterDate" title="Reset Filter Date to" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </span>
                                </a>
                            @endif
                        </div>

                    </div> 
            
                </div>
                
                <!-- Filter Error Date -->                                       
                @if ($dateFrom > $dateTo)
                    <!-- 2 ROW FILTER VALUE-->
                    <div class="flex flex-col md:flex-row p-1 my-1">
                        <!-- Value From -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                            
                            <div class="w-5/12 px-1">                                                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end rounded-sm bg-green-100 border-1 border-gray-200"> 
                                    <span class="italic text-sm text-red-500 p-1 px-2"> Date from is bigger than Date To</span>
                            </div>
                            <div class="w-1/12">                                    
                            </div>

                        </div> 
                    </div>
                @endif

            </div>
            @endif

        </div>  

        <!-- SEARCH -->
        <div class="flex flex-col bg-blue-800 mx-auto my-2 text-black">

            <div class="flex flex-row justify-between items-center w-full text-white">
                <span class="capitalize text-lg px-2">
                    <a wire:click="activateSearch" class="cursor-pointer" title="{{($showSearch % 2 != 0) ? 'Close Search' : 'Open Search'}}">search</a>
                </span>
                <!-- Open/Close Buttons -->
                <div class="p-2">
                    @if ($showSearch % 2 != 0)
                        <a wire:click="activateSearch" class="cursor-pointer" title="Close Search">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @else
                        <a wire:click="activateSearch" class="cursor-pointer" title="Open Search">
                            <i class="fa-solid fa-caret-down"></i>
                        </a>
                    @endif
                </div>
            </div>

                        

            @if ($showSearch % 2 != 0)

            <div class="flex flex-col bg-zinc-200 pt-1 pb-6 my-0">

                <div class="flex flex-wrap md:flex-row justify-start items-start gap-2 text-sm w-full mb-0">
                    <div class="flex flex-row p-2 ml-2 items-center gap-2">
                        <i class="fa-solid fa-fingerprint"></i>
                        <span class="capitalize">name</span>    
                        <input type="radio" wire:model.live="searchType" value="name" class="cursor-pointer">
                    </div>
                    <div class="flex flex-row p-2 ml-2 items-center gap-2">
                        <i class="fa-solid fa-text-width"></i>
                        <span class="capitalize">email</span>    
                        <input type="radio" wire:model.live="searchType" value="email" class="cursor-pointer">
                    </div>                            
                </div>
                <!-- Search Word -->
                <div class="relative w-full px-4">
                    <div class="absolute top-1 bottom-0 left-5 text-gray-600">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input wire:model.live="search" type="search"
                        class="w-full bg-gray-100 rounded-sm pl-8 py-1 text-zinc-800 text-sm placeholder-zinc-800 focus:outline-none focus:ring-0 focus:border-zinc-600 border-2 border-zinc-800"
                        placeholder="Search by {{ $searchType }}">
                    @if ($search != '')
                    <div class="absolute top-1 bottom-0 right-5 text-slate-700">
                        <a wire:click.prevent="clearSearch" title="Clear Search" class="cursor-pointer">
                            <span class="text-red-600 hover:text-red-400">
                                <i class="fa-sm fa-solid fa-xmark"></i>
                            </span>
                        </a>
                    </div>
                    @endif
                </div>

            </div>

            @endif

        </div>

        <!-- TABLE USERS HEADER AND BULK ACTIONS -->
        @if($total > 0)

            <div class="flex flex-row justify-between md:items-end bg-green-600 text-white mt-4">

                <!-- Users Found -->
                <div class="p-2">
                    <span class="text-lg">Users Found ({{ $search != '' ? $found : $total }})</span>
                </div>       
                
                <!-- Pagination -->
                <div class="flex flex-row justify-center items-center p-2 gap-4">
                    
                    <i class="fa-solid fa-book-open" title="Pagination"></i>
                    <select wire:model.live="perPage"
                        class="w-full bg-gray-200 rounded-sm text-black text-end focus:outline-none focus:ring-0 focus:border-gray-400 border-2 border-zinc-200 "
                        title="Users per Page">
                        <option value="3">3</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                </div>
                
            </div>  

            <!-- TABLE INFO / FONT / EXPORT ALL / BULK ACTIONS -->
            <div class="flex flex-col justify-between p-2 text-xs bg-zinc-200">

                <!-- TABLE INFO / FONT / EXPORT ALL -->
                <div class="flex flex-row">                    

                    <!-- TABLE INFO / FONT -->
                    <div class="flex flex-col w-full">
                        <div class="flex flex-col md:flex-row justify-start gap-0 md:gap-7">
                            <div class="flex flex-row gap-5 md:gap-5">
                                <span class="capitalize font-bold">table info</span>
                                @if($smallView)                                
                                    <a wire:click="activateSmallView({{0}})" 
                                        class="hover:text-green-600 transition duration-1000 ease-in-out cursor-pointer"
                                        title="See more Info"> 
                                        <span class="px-1">more</span><i class="fa-solid fa-up-right-and-down-left-from-center"></i>                            
                                    </a>                               
                                        @else                                    
                                        <a wire:click="activateSmallView({{1}})" 
                                            class="hover:text-green-600 transition duration-1000 ease-in-out cursor-pointer"
                                            title="See less Info">
                                            <span class="px-1">less</span><i class="fa-solid fa-down-left-and-up-right-to-center"></i>                           
                                        </a> 
                                @endif
                            </div>
                            <div class="flex flex-row gap-5 md:gap-5">
                                <span class="capitalize font-bold">table font</span>
                                @if($smallFont)
                                        <a wire:click="activateSmallFont({{0}})" 
                                            class="hover:text-green-600 transition duration-1000 ease-in-out cursor-pointer"
                                            title="Big Font"> 
                                            <span class="px-0">big</span><i class="fa-lg fa-solid fa-a"></i>                            
                                        </a>
                                        @else
                                            <a wire:click="activateSmallFont({{1}})" 
                                                class="hover:text-green-600 transition duration-1000 ease-in-out cursor-pointer"
                                                title="Small Font">
                                                <span class="px-0">small</span><i class="fa-solid fa-a"></i>                           
                                            </a>
                                    @endif
                            </div>    
                        </div>
                    </div>
                    <!-- EXPORT ALL -->
                    <div class="flex flex-col w-full items-end">
                        <form action="{{ route('entries.export') }}" method="POST">
                            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                            @csrf
                            <input type="hidden" id="entries" name="entries"
                                value="{{ $usersRaw->pluck('id') }}">
                            
                            <button
                                class="hover:text-amber-600 transition duration-1000 ease-in-out cursor-pointer"
                                title="Export All as Excel file">
                                <i class="text-green-600 fa-solid fa-file-export"></i>                                 
                                <span class="text-xs font-normal px-1">export all</span>
                            </button>                            
                        </form>
                    </div>

                </div>    

                <!-- BULK ACTIONS -->
                <div class="flex flex-row justify-between md:justify-start py-2 gap-2">
                    @if (count($okselections) > 0)

                        <div class="flex flex-row gap-2">                            
                            <span class="font-bold capitalize">bulk actions </span>
                            <span>selected ({{ count($okselections) }})</span>
                        </div>
                        
                        <div class="flex flex-row gap-2">   
                            <!-- Unselect -->                         
                            <a wire:click.prevent="bulkClear" class="cursor-pointer" title="Unselect Entries">
                                <i class="fa-solid fa-xmark text-blue-600"></i>
                            </a>                              
                            <!-- Delete -->         
                            <a wire:click.prevent="bulkDelete" wire:confirm="Are you sure you want to delete this items?"
                                class="cursor-pointer" title="Delete Selected">
                                <i class="fa-solid fa-trash text-red-600"></i>
                            </a>
                            <!-- Export -->            
                            <form action="{{ route('entries.exportbulk') }}" method="POST">
                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                    @csrf
                                    <input type="hidden" id="listEntriesBulk" name="listEntriesBulk"
                                        value="{{ implode(',', $okselections) }}">
                                    
                                    <button class="cursor-pointer" title="Export Selected as Excel file">
                                        <i class="fa-solid fa-file-export text-green-600"></i>
                                    </button>
                            </form>
                        </div> 
                            
                        @else
                            <div class="flex flex-row gap-2">
                                <span class="font-bold capitalize">Bulk actions</span>
                                <span class="italic text-xs font-normal"> no selections</span>
                            </div>
                        @endif
                </div>


            </div>                    

        @endif         

        @if ($users->count())
            <!-- TABLE -->
            <div class="bg-black text-white my-0">
                <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <!-- TABLE HEADER -->
                            <thead>
                                <tr class="text-left text-sm font-normal capitalize">
                                    <th></th>
                                    <th wire:click="sorting('id')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'id' ? 'text-yellow-400' : '' }}">
                                        id {!! $sortLink !!}</th>
                                    <th wire:click="sorting('name')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'name' ? 'text-yellow-400' : '' }}">
                                        Name {!! $sortLink !!}</th>
                                    <th wire:click="sorting('email')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'email' ? 'text-yellow-400' : '' }}">
                                        Email {!! $sortLink !!}</th>
                                    <th wire:click="sorting('is_admin')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'is_admin' ? 'text-yellow-400' : '' }}">
                                        Admin {!! $sortLink !!}</th>
                                    <th scope="col" class="p-2 text-center">Entries</th>
                                    @if(!$smallView)
                                    <th wire:click="sorting('created_at')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'created_at' ? 'text-yellow-400' : '' }}">
                                        Created {!! $sortLink !!}</th>
                                    <th wire:click="sorting('updated_at')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'updated_at' ? 'text-yellow-400' : '' }}">
                                        Updated {!! $sortLink !!}</th>
                                    @endif                                    
                                    <th scope="col" class="p-2 text-center">actions</th>
                                </tr>
                            </thead>
                            <!-- TABLE BODY -->
                            <tbody>
                                @foreach ($users as $user)
                                    <tr
                                        class="text-black {{$smallFont ? 'text-xs' : 'text-sm'}} leading-6 {{in_array($user->id, $okselections) ? 'bg-green-200' : 'even:bg-zinc-100 odd:bg-zinc-50'}} transition-all duration-1000 hover:bg-yellow-200">

                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ intval($user->id) }} 
                                                id={{ $user->id }}
                                                {{ in_array($user->id, $selections) ? 'checked' : '' }}
                                                >
                                        </td>
                                        <td class="p-2 pr-12 {{ $column == 'id' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $user->id }}</td>
                                        <td class="p-2 pr-12 {{ $column == 'name' ? 'bg-yellow-400 font-bold text-slate-800 transition-all duration-1000' : '' }}">
                                            <a href="#">{{ $user->name }}</a>
                                        </td>
                                        <td class="p-2 pr-12 {{ $column == 'email' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $user->email }}</td>
                                        <td class="p-2 pr-12 {{ $column == 'is_admin' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}"> {{ ($user->is_admin == 1) ? 'Yes' : 'No' }}</td>
                                        <td class="p-2 pr-12">{{ $user->entries->count() }}</td>
                                        @if(!$smallView)
                                        <td class="p-2 pr-12 {{ $column == 'created_at' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $user->created_at }}</td>
                                        <td class="p-2 pr-12 {{ $column == 'updated_at' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $user->updated_at }}</td>
                                        @endif                                       
                                        <!-- ACTIONS --> 
                                        <td class="p-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <!-- Show -->
                                                <a href="#" title="Show">
                                                    <i
                                                        class="fa-solid fa-circle-info text-orange-600 hover:text-orange-700 transition duration-1000 ease-in-out"></i>
                                                </a>                                                                                            
                                                <!-- Delete -->
                                                <form action="#" method="POST">
                                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                @csrf
                                                <!-- Dirtective to Override the http method -->
                                                @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Delete PERMANENTLY User with (ID: {{  $user->id }})?')"                                                        
                                                        title="Delete PERMANENTLY">                                                        
                                                        <span
                                                            class="text-red-600 hover:text-black transition-all duration-500">
                                                            <i
                                                                class="fa-solid fa-trash"></i></span>
                                                    </button>
                                                </form>                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                </div>

            </div>
            @else
                <div
                    class="flex flex-row justify-between items-center bg-black text-white rounded-sm w-full mx-auto p-4">
                    <span>No users found in the system.</span>
                    <a wire:click.prevent="resetAll" title="Reset">
                        <i
                            class="fa-lg fa-solid fa-circle-xmark cursor-pointer px-2 text-red-600 hover:text-red-400 transition duration-1000 ease-in-out"></i>
                    </a>
                    </span>
                </div>            
            @endif 



        
        <!-- Pagination Links -->
        <div class="py-2 px-4">
            {{ $users->links() }}
        </div>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                class="fa-solid fa-angle-up"></i></button> 


    </div>

    <!-- Footer -->
    <div class="flex flex-row justify-center items-center p-2 mt-4 bg-green-600 rounded-sm">
        <span class="font-bold text-xs text-white">xavulankis 2025</span>
    </div>

</div>



