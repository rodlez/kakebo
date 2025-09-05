<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-col bg-green-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('message') }}</span>
                <a href="/balances/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex flex-col bg-red-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('error') }}</span>
                <a href="/balances/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-row justify-between items-center gap-2 p-2 font-bold uppercase bg-black text-white rounded-sm">
        
        <div>
            <a href="/balances" class="border-b-2 border-b-yellow-400">accounts</a> 
        </div>

        <div>
            <a href="{{route('balances.create')}}"
                class="capitalize text-white text-sm rounded-sm p-1 bg-blue-600 text-black hover:text-white transition duration-1000 ease-in-out"
                title="Create New Account">new</a>
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

        </div>

        @if ($showFilters % 2 != 0)
            <!-- Filters Options -->    
            <div class="flex flex-col bg-zinc-200 opacity-95 py-2">

                @if ($isAdmin)
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
                                <select wire:model.live="userID" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                    <option value="0">All</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                                            
                            </div>
                            <div class="w-1/12">
                                @if ($userID > 0)
                                    <a wire:click.prevent="clearFilterUser" title="Reset Filter User" class="cursor-pointer">
                                        <span class="text-red-400 hover:text-red-600 px-1 justify-center items-center"><i
                                                class="fa-solid fa-circle-xmark"></i></span>
                                    </a>
                                @endif
                            </div>

                        </div>

                    </div>
                @endif

                <!-- 2 ROW FILTER -->
                <div class="flex flex-col md:flex-row p-1 my-1">
                    <!-- Source -->
                    <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                        
                        <div class="w-5/12 px-1">
                            <span><i class="fa fa-money-bill"></i></span>
                            <span>Payment <span
                            class="text-xs">({{ $sources->count() }})</span></span>                            
                        </div>                        
                        <div class="flex flex-row w-6/12 justify-end">                            
                            <select wire:model.live="sour" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                <option value="0">All</option>
                                @foreach ($sources as $source)
                                    <option value="{{ $source->source }}">{{ $source->source }}</option>
                                @endforeach
                            </select>                                                            
                        </div>
                        <div class="w-1/12">
                            @if ($sour != 0)
                                <a wire:click.prevent="clearFilterSource" title="Reset Filter Source" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1"><i
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


                <!-- 2 ROW FILTER VALUE-->
                <div class="flex flex-col md:flex-row p-1 my-1">
                    <!-- Value From -->
                    <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                        
                        <div class="w-5/12 px-1">
                            <span><i class="fa fa-eur"></i></span>
                            <span>Value <span class="text-sm font-bold">from</span></span>                            
                        </div>                        
                        <div class="flex flex-row w-6/12 justify-end">                            
                            <input type="number" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer" placeholder="From"
                                wire:model.live="valueFrom">                                                                                            
                        </div>
                        <div class="w-1/12">
                            @if ($initialValueFrom != $valueFrom)
                                <a wire:click.prevent="clearFilterValue" title="Reset Filter Value from"
                                    class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </span>
                                </a>
                            @endif
                        </div>

                    </div>

                    <!-- Value To -->
                    <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                        
                        <div class="w-5/12 px-1">
                            <span><i class="fa fa-eur"></i></span>
                            <span>Value <span class="text-sm font-bold">to</span></span>                            
                        </div>                        
                        <div class="flex flex-row w-6/12 justify-end">                            
                            <input type="number" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer" placeholder="From"
                                wire:model.live="valueTo">                                                                                            
                        </div>
                        <div class="w-1/12">
                            @if ($initialValueTo != $valueTo)
                                <a wire:click.prevent="clearFilterValue" title="Reset Filter Value to"
                                    class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </span>
                                </a>
                            @endif
                        </div>

                    </div> 
            
                </div>

                <!-- Filter Error Value -->                                       
                @if ($valueFrom > $valueTo)
                    <!-- 2 ROW FILTER VALUE-->
                    <div class="flex flex-col md:flex-row p-1 my-1">
                        <!-- Value From -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                            
                            <div class="w-5/12 px-1">                                                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end rounded-sm bg-green-100 border-1 border-gray-200"> 
                                    <span class="italic text-sm text-red-500 p-1 px-2"> Value from is bigger than Value To</span>
                            </div>
                            <div class="w-1/12">                                    
                            </div>

                        </div> 
                    </div>
                @endif


            </div>
        @endif


        <!-- SEARCH -->
        <div class="flex flex-col bg-blue-800 mx-auto my-2">

            <div class="flex flex-row justify-between items-center w-full text-white">
                <span class="capitalize text-lg px-2">
                    <a wire:click="activateSearch" class="cursor-pointer">search</a>
                </span>                    
            </div>


            <div class="flex flex-col bg-zinc-200 py-2">
                
                <!-- Search Word -->
                <div class="relative w-full px-4">
                    <div class="absolute top-1 bottom-0 left-5 text-gray-600">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input wire:model.live="search" type="search"
                        class="w-full bg-gray-100 rounded-sm pl-8 py-1 text-zinc-800 text-sm placeholder-zinc-800 focus:outline-none focus:ring-0 focus:border-zinc-600 border-2 border-zinc-800"
                        placeholder="Search by name">
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

        </div>



        <!-- CRITERIA -->                                 
                
            <div class="flex flex-col my-0">
                                
                <!-- HEADER - Filters and Search Criteria -->
                <div class="flex flex-row justify-between items-center p-2 text-white {{(count($criteria) > 0) ? 'bg-pink-600' : 'bg-gray-400' }}">
                    <span class="text-lg capitalize">filters & search criteria</span>
                    <!-- Clear ALL Criteria for search and filters -->
                    @if (count($criteria) > 0)
                        <div>
                            <a wire:click.prevent="resetAll" title="Clear all filters">
                                <i class="fa-solid fa-xmark cursor-pointer"></i>
                            </a>
                        </div>
                    @endif
                </div>
                               
                
                    <!-- Filters and Search Criteria -->
                    <div class="flex flex-col bg-zinc-200 py-0 my-0">

                        @if (count($criteria) > 0)

                            <div class="flex flex-wrap text-white text-xs capitalize w-full p-2 gap-3 sm:gap-4">
                                <!-- Search -->
                                @if ($search != '')
                                    <div class="flex relative">                                
                                        <div
                                            class="bg-blue-800 p-2 rounded-sm border-1 border-blue-600">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <span class="uppercase font-bold">search</span>
                                        </div>
                                        <a wire:click.prevent="clearSearch" title="Clear Search" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>
                                @endif
                                <!-- User -->
                                @if ($userID > 0)
                                    <div class="flex relative">                                
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-user"></i>
                                            <span class="uppercase font-bold">user</span>
                                            <span>({{ $criteria['user'] }})</span>
                                        </div>
                                        <a wire:click.prevent="clearFilterUser" title="Clear Filter User" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>
                                @endif                                
                                <!-- Payment -->
                                @if ($sour != 0)
                                    <div class="flex relative">                                
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-money-bill"></i>
                                            <span class="uppercase font-bold">payment</span>
                                            <span>({{ $criteria['source'] }})</span>
                                        </div>
                                        <a wire:click.prevent="clearFilterSource" title="Clear Filter Payment" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>
                                @endif                                
                                <!-- Date -->
                                @if ($initialDateTo != $dateTo || $initialDateFrom != $dateFrom)
                                    <div class="flex relative">
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-calendar"></i>
                                            <span class="uppercase font-bold">date</span>
                                            <span class="lowercase">{{ '(' . date('d-m-Y', strtotime($dateFrom)) . ' to ' . date('d-m-Y', strtotime($dateTo)) . ')' }}</span>
                                        </div>                                
                                        <a wire:click.prevent="clearFilterDate" title="Clear Filter Date" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>
                                @endif
                                <!-- Value -->
                                @if ($initialValueTo != $valueTo || $initialValueFrom != $valueFrom)
                                    <div class="flex relative">
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-eur"></i>
                                            <span class="uppercase font-bold">value</span>
                                            <span class="lowercase">{{ '(' . $valueFrom . ' to ' . $valueTo . ')' }}</span>
                                        </div>                                
                                        <a wire:click.prevent="clearFilterValue" title="Clear Filter Value" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>
                                @endif                                          

                            </div>
                        
                        @else

                            <span class="font-normal text-sm italic p-2">No filters or search active.</span>

                        @endif
                    
                    </div>

            </div>

            <!-- Account Info -->
            <div class="flex flex-row justify-between md:items-end bg-slate-900 text-white mt-4">

                    <!-- Account Found -->
                    <div class="p-2">
                        <span class="text-lg">Accounts Found ({{ $total }})</span>
                    </div>       
                    
                    <!-- Pagination -->
                    <div class="flex flex-row justify-center items-center p-2 gap-4">
                        
                        <i class="fa-solid fa-book-open" title="Pagination"></i>
                        <select wire:model.live="perPage"
                            class="w-full bg-gray-200 rounded-sm text-black text-end focus:outline-none focus:ring-0 focus:border-gray-400 border-2 border-zinc-200 "
                            title="Entries per Page">
                            <option value="3">3</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>

                    </div>
                    
            </div>

            <!-- Bulk Actions -->
            <div class="flex flex-row justify-between md:justify-start text-sm p-2 gap-2">
                @if (count($okselections) > 0)
                        
                        <div class="flex flex-row gap-2">                            
                            <span class="font-bold capitalize">bulk actions </span>
                            <span>selected ({{ count($okselections) }})</span>
                        </div>

                        <div class="flex flex-row gap-2">                            
                            <a wire:click.prevent="bulkClear" class="cursor-pointer" title="Unselect Entries">
                                <i class="fa-solid fa-rotate-right text-blue-600"></i>
                            </a>
                                                
                            <a wire:click.prevent="bulkDelete" wire:confirm="Are you sure you want to delete this items?"
                                class="cursor-pointer" title="Delete Selected">
                                <i class="fa-solid fa-trash text-red-600"></i>
                            </a>
                        </div>                                                    

                @else
                    <div class="flex flex-row gap-2">
                        <span class="font-bold capitalize">Bulk actions</span>
                        <span>no selections</span>
                    </div>
                @endif
            </div>
            

            @if ($balances->count())
                <!-- TABLE -->
                <div class="bg-black text-white my-0">
                    <div class="overflow-x-auto">
                        
                        <table class="min-w-full">
                            <!-- TABLE HEADER -->
                            <thead>
                                <tr class="text-left text-sm font-normal capitalize">
                                    <th></th>
                                    <th wire:click="sorting('id')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'id' ? 'text-yellow-600' : '' }}">
                                        id {!! $sortLink !!}</th>
                                    @if($isAdmin)
                                    <th wire:click="sorting('user_id')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'user_id' ? 'text-yellow-600' : '' }}">
                                        user {!! $sortLink !!}</th>
                                    @endif
                                    <th wire:click="sorting('date')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'date' ? 'text-yellow-600' : '' }}">
                                        date {!! $sortLink !!}</th>
                                    <th wire:click="sorting('name')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'name' ? 'text-yellow-600' : '' }}">
                                        name {!! $sortLink !!}</th>
                                    <th wire:click="sorting('source')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'source' ? 'text-yellow-600' : '' }}">
                                        payment {!! $sortLink !!}</th>
                                    <th wire:click="sorting('total')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'total' ? 'text-yellow-600' : '' }}">
                                        total {!! $sortLink !!}</th>
                                    <th wire:click="sorting('created_at')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'created_at' ? 'text-yellow-600' : '' }}">
                                        created {!! $sortLink !!}</th>
                                    <th wire:click="sorting('updated_at')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'updated_at' ? 'text-yellow-600' : '' }}">
                                        updated {!! $sortLink !!}</th>
                                    <th scope="col" class="p-2 text-center capitalize">actions</th>
                                </tr>
                            </thead>
                            <!-- TABLE BODY -->
                            <tbody>
                                @foreach ($balances as $balance)
                                    <tr
                                        class="text-black text-sm leading-6 {{in_array($balance->id, $okselections) ? 'bg-green-200' : 'even:bg-zinc-100 odd:bg-zinc-50'}} transition-all duration-1000 hover:bg-yellow-200">                                        
                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ intval($balance->id) }} 
                                                id={{ $balance->id }}
                                                {{ in_array($balance->id, $selections) ? 'checked' : '' }}
                                                >
                                        </td>                                        
                                        <td class="p-2 pr-12 {{ $column == 'id' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ $balance->id }}</td>
                                        @if($isAdmin)
                                            <td class="p-2 {{ $column == 'user_id' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ $balance->user->name }}</td>
                                        @endif
                                        <td class="p-2 {{ $column == 'date' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ date('d-m-Y', strtotime($balance->date)) }}</td>
                                        <td class="p-2 {{ $column == 'name' ? 'bg-yellow-300 font-bold text-red transition-all duration-1000' : '' }}"> <a
                                                href="{{ route('balances.show', $balance) }}">{{ $balance->name }}</a>
                                        </td>
                                        <td class="p-2 {{ $column == 'source' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ $balance->source }}</td>
                                        <td class="p-2 {{ $column == 'total' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ $balance->total }}</td>
                                        <td class="p-2 {{ $column == 'created_at' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ date('d-m-Y', strtotime($balance->created_at)) }}</td>
                                        <td class="p-2 {{ $column == 'updated_at' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ date('d-m-Y', strtotime($balance->updated_at)) }}</td>
                                        
                                        <td class="p-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <!-- Show -->
                                                <a href="{{ route('balances.show', $balance) }}" title="Show">
                                                    <i
                                                        class="fa-solid fa-circle-info text-amber-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Edit -->
                                                <a href="{{ route('balances.edit', $balance) }}" title="Edit">
                                                    
                                                    <i
                                                        class="fa-solid fa-pen-to-square text-green-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form action="{{ route('balances.destroy', $balance) }}" method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Are you sure you want to delete the balance: {{ $balance->name }}?')"
                                                        title="Delete">                                                        
                                                        <i
                                                            class="fa-solid fa-trash text-red-600 hover:text-black transition duration-1000 ease-in-out"></i>
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
                    class="flex flex-row justify-between items-center bg-black text-white rounded-lg p-4 mx-2 sm:mx-0">
                    <span>No balances found in the system.</span>
                    <a wire:click.prevent="clearSearch" title="Reset">
                        <i
                            class="fa-lg fa-solid fa-circle-xmark cursor-pointer px-2 text-red-600 hover:text-red-400 transition duration-1000 ease-in-out"></i>
                    </a>
                    </span>
                </div>
            @endif
                
            <!-- Pagination Links -->
            <div class="py-2 px-4">
                {{ $balances->links() }}
            </div>

    </div>       

    <!-- Footer -->
    <div class="flex flex-row justify-center items-center p-2 mt-4 bg-black rounded-sm">
        <span class="font-bold text-xs text-white">xavulankis 2025</span>
    </div>
   

</div>


