<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-col bg-green-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('message') }}</span>
                <a href="/archive/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex flex-col bg-red-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('error') }}</span>
                <a href="/archive/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-row justify-between items-center gap-2 p-2 font-bold uppercase bg-red-600 text-white rounded-sm">
        
        <div>
            <a href="/archive" class="border-b-2 border-b-white">Archive</a> 
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

                    <!-- 2 ROW FILTER -->
                    <div class="flex flex-col md:flex-row p-1 my-1">
                        <!-- TYPES -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                            
                            <div class="w-5/12 px-1">
                                <span><i class="fa fa-wallet"></i></span>
                                <span>Types</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="types" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                <option value="2">All</option>
                                <option value="0">Expense</option>
                                <option value="1">Income</option>
                            </select>
                                                            
                            </div>
                            <div class="w-1/12">
                                @if ($types != 2)
                                <a wire:click.prevent="clearFilterTypes" title="Reset Filter Types" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1"><i
                                            class="fa-solid fa-circle-xmark"></i></span>
                                </a>
                                @endif
                            </div>

                        </div>

                        <!-- Frequency -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                                
                            <div class="w-5/12 px-1">
                                <span><i class="fa fa-clock"></i></span>
                                <span>Frequency <span
                                    class="text-xs">({{ $frequencies->count() }})</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="freq" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                    <option value="0">All</option>
                                @foreach ($frequencies as $frequency)
                                    <option value="{{ $frequency->frequency }}">{{ $frequency->frequency }}</option>
                                @endforeach
                                </select>
                                                            
                            </div>
                            <div class="w-1/12">
                            @if ($freq != 0)
                                <a wire:click.prevent="clearFilterFrequency" title="Reset Filter Frequency" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1"><i
                                            class="fa-solid fa-circle-xmark"></i></span>
                                </a>
                            @endif
                            </div>

                        </div>                
                
                    </div>

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

                        <!-- Balance -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                                
                            <div class="w-5/12 px-1">
                                <span><i class="fa fa-piggy-bank"></i></span>
                                <span>Accounts <span
                                class="text-xs">({{ $balances->count() }})</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="bal" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                    <option value="0">All</option>
                                    @foreach ($balances as $balance)
                                        <option value="{{ $balance->name }}">{{ $balance->name }}</option>
                                    @endforeach
                                </select>
                                                            
                            </div>
                            <div class="w-1/12">
                            @if ($bal != 0)
                                <a wire:click.prevent="clearFilterBalance" title="Reset Filter Balance" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1"><i
                                            class="fa-solid fa-circle-xmark"></i></span>
                                </a>
                            @endif
                            </div>

                        </div>                
                
                    </div>

                    <!-- 2 ROW FILTER -->
                    <div class="flex flex-col md:flex-row p-1 my-1">
                        <!-- Company -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                            
                            <div class="w-5/12 px-1">
                                <span><i class="fa fa-industry"></i></span>
                                <span>Company <span
                                class="text-xs">({{ $companies->count() }})</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="compa" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                    <option value="0">All</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->company }}">{{ $company->company }}</option>
                                    @endforeach
                                </select>                                                            
                            </div>
                            <div class="w-1/12">
                                @if ($compa != 0)
                                    <a wire:click.prevent="clearFilterCompany" title="Reset Filter Company" class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-1"><i
                                                class="fa-solid fa-circle-xmark"></i></span>
                                    </a>
                                @endif
                            </div>

                        </div>

                        <!-- Category -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                                
                            <div class="w-5/12 px-1">
                                <span><i class="fa fa-tag"></i></span>
                                <span>Category <span
                                class="text-xs">({{ count($categories) }})</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="cat" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                    <option value="0">All</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                                            
                            </div>
                            <div class="w-1/12">
                            @if ($cat > 0)
                                <a wire:click.prevent="clearFilterCategory" title="Reset Filter Category" class="cursor-pointer">
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

                    <!-- 1 ROW FILTER -->
                    <div class="flex flex-col md:flex-row p-1 my-1">
                        <!-- TAGS -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                        
                            <div class="w-5/12 px-1">
                                <span><i class="fa fa-tags"></i></span>
                                <span>Tags <span
                                    class="text-xs">({{ count($tags) }})</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end ml-1">                            
                                <select wire:model.live="selectedTags" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer px-4" name="selectedTags" id="selectedTags" multiple>
                                    <option value="0">All</option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                                    @endforeach
                                </select>                                                        
                            </div>
                            <div class="w-1/12">
                                @if ($selectedTags != [])
                                    <a wire:click="clearFilterTag" title="Reset Filter Tags" class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2"><i
                                                class="fa-solid fa-circle-xmark"></i></span>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                
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
                            <span class="capitalize">id</span>    
                            <input type="radio" wire:model.live="searchType" value="entries.id" class="cursor-pointer">
                        </div>
                        <div class="flex flex-row p-2 ml-2 items-center gap-2">
                            <i class="fa-solid fa-text-width"></i>
                            <span class="capitalize">title</span>    
                            <input type="radio" wire:model.live="searchType" value="title" class="cursor-pointer">
                        </div>
                        <div class="flex flex-row p-2 items-center gap-2">
                            <i class="fa-solid fa-industry"></i>
                            <span class="capitalize">company</span>    
                            <input type="radio" wire:model.live="searchType" value="company" class="cursor-pointer">
                        </div>
                        <div class="flex flex-row p-2 items-center gap-2">
                            <i class="fa-solid fa-piggy-bank"></i>
                            <span class="capitalize">account</span>    
                            <input type="radio" wire:model.live="searchType" value="balances.name" class="cursor-pointer">
                        </div>         
                    </div>
                    <!-- Search Word -->
                    <div class="relative w-full px-4">
                        <div class="absolute top-1 bottom-0 left-5 text-gray-600">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input wire:model.live="search" type="search"
                            class="w-full bg-gray-100 rounded-sm pl-8 py-1 text-zinc-800 text-sm placeholder-zinc-800 focus:outline-none focus:ring-0 focus:border-zinc-600 border-2 border-zinc-800"
                            placeholder="Search by {{ ($searchType == 'balances.name') ? 'account' : $searchType }}">
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

            
            <!-- CRITERIA -->                                 
                
            <div class="flex flex-col my-2">
                                
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
                                            <span>({{ $criteria['searchType'] }})</span>
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
                                <!-- Types -->
                                @if ($types != 2)
                                    <div class="flex relative">                                
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-wallet"></i>
                                            <span class="uppercase font-bold">type</span>
                                            <span>({{ $types == 1 ? 'income' : 'expense' }})</span>
                                        </div>
                                        <a wire:click.prevent="clearFilterTypes" title="Clear Filter Type" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>                            
                                @endif
                                <!-- Frequency -->
                                @if ($freq != 0)
                                    <div class="flex relative">                                
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-clock"></i>
                                            <span class="uppercase font-bold">frequency</span>
                                            <span>({{ $criteria['frequency'] }})</span>
                                        </div>
                                        <a wire:click.prevent="clearFilterFrequency" title="Clear Filter Frequency" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>                            
                                @endif
                                <!-- Source -->
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
                                <!-- Balance -->
                                @if ($bal > 0)
                                    <div class="flex relative">                                
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-piggy-bank"></i>
                                            <span class="uppercase font-bold">balance</span>
                                            <span>({{ $criteria['balance'] }})</span>
                                        </div>
                                        <a wire:click.prevent="clearFilterBalance" title="Clear Filter Balance" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>                            
                                @endif
                                <!-- Company -->
                                @if ($compa != 0)
                                    <div class="flex relative">                                
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-industry"></i>
                                            <span class="uppercase font-bold">company</span>
                                            <span>({{ $criteria['company'] }})</span>
                                        </div>
                                        <a wire:click.prevent="clearFilterCompany" title="Clear Filter Company" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>
                                @endif
                                <!-- Category -->
                                @if ($cat > 0)
                                    <div class="flex relative">                                
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-tag"></i>
                                            <span class="uppercase font-bold">category</span>
                                            <span>({{ $criteria['category'] }})</span>
                                        </div>
                                        <a wire:click.prevent="clearFilterCategory" title="Clear Filter Category" class="cursor-pointer">
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
                                
                                <!-- Tags -->
                                @if (!in_array('0', $this->selectedTags) && count($this->selectedTags) != 0)
                                    <div class="flex relative">
                                        <div
                                            class="bg-green-800 p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-tags"></i>
                                            <span class="uppercase font-bold">tags</span>
                                            <span class="capitalize">{{ '(' . implode(', ', $tagNames) . ')' }}</span>
                                        </div>                                
                                        <a wire:click.prevent="clearFilterTag" title="Clear Filter Tag" class="cursor-pointer">
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


            @if($total > 0)  
            <!-- STATS -->
            <div class="flex flex-col my-2">

                <div class="flex flex-row justify-between items-center w-full text-white bg-yellow-800">
                    <span class="capitalize text-lg px-2">
                        <a wire:click="activateStats" class="cursor-pointer" title="{{($showStats % 2 != 0) ? 'Close Stats' : 'Open Stats'}}">stats</a>
                    </span>
                    <!-- Open/Close Buttons -->
                    <div class="p-2">
                        @if ($showStats % 2 != 0)
                            <a wire:click="activateStats" class="cursor-pointer" title="Close Stats">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @else
                            <a wire:click="activateStats" class="cursor-pointer" title="Open Stats">
                                <i class="fa-solid fa-caret-down"></i>
                            </a>
                        @endif
                    </div>
                </div>

               @if ($showStats % 2 != 0)
                <div class="flex flex-col lg:flex-row justify-between bg-zinc-200 p-2 text-xs gap-2 md:gap-4">       
                    <div class="flex flex-row text-xs">                        
                        <span class="font-bold">Users <span class="font-normal">({{ $stats['users'] }})</span></span>    
                    </div>       
                    <div class="flex flex-row text-xs">
                        <div class="flex flex-row justify-between w-full gap-4">
                            <span class="font-bold">Days <span class="font-normal">({{ $stats['days'] }})</span></span>  
                            <div class="flex flex-col text-xs items-end gap-0">                                
                                <span class="p-0">{{ date('d-m-Y', strtotime($stats['dateFrom'])) }}</span>
                                <span class="p-0">{{ date('d-m-Y', strtotime($stats['dateTo'])) }}</span>                                    
                            </div>                              
                        </div>
                    </div>
                    <div class="flex flex-row md:flex-wrap text-xs">
                        <div class="flex flex-row justify-between w-full gap-4">
                            <div class="flex flex-col">
                                <span class="p-0 font-bold">Balance </span>    
                            </div>
                            <div class="flex flex-col">
                                <div class="flex flex-row text-end gap-2">                                
                                    <div class="flex flex-col">
                                        <span>Incomes ({{$stats['numberIncomes']}})</span>
                                        <span>Expenses ({{$stats['numberExpenses']}})</span>    
                                        <span class="font-bold">Total</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-green-600">{{$stats['incomes']}} €</span>
                                        <span class="text-red-600">{{$stats['expenses']}} €</span>
                                        <span class="{{($stats['incomes'] - $stats['expenses'] > 0) ? 'text-green-600' : 'text-red-600'}}">{{$stats['incomes'] - $stats['expenses']}} €</span>
                                    </div>
                                </div>                        
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row md:flex-wrap text-xs">
                        <div class="flex flex-row justify-between w-full gap-4">
                            <span class="p-0 font-bold">Payment</span>    
                            <div class="flex flex-col text-end">
                                <span>Cash ({{$stats['sourceCash']}})</span>
                                <span>Card ({{$stats['sourceCard']}})</span>
                                <span>Stocks ({{$stats['sourceStocks']}})</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row md:flex-wrap text-xs">                        
                        <div class="flex flex-row justify-between w-full gap-4">
                            <span class="font-bold">Accounts ({{$stats['numberAccounts']}})</span>  
                            <div class="flex flex-col">
                                @if($stats['numberAccounts'] > 0)
                                    <select class="text-end" multiple>                              
                                        @foreach ($stats['accounts'] as $account)                            
                                            <option value="">{{$account}}</option>
                                        @endforeach
                                    </select>    
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row md:flex-wrap text-xs">                        
                        <div class="flex flex-row justify-between w-full gap-4">    
                            <span class="font-bold">Companies ({{$stats['numberCompanies']}})</span> 
                            <div class="flex flex-col">
                                @if($stats['numberCompanies'] > 0)
                                    <select class="text-end" multiple>                              
                                        @foreach ($stats['companies'] as $company)                            
                                            <option value="">{{$company}}</option>
                                        @endforeach
                                    </select>    
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row md:flex-wrap text-xs">                        
                        <div class="flex flex-row justify-between w-full gap-4">
                            <span class="font-bold">Categories ({{$stats['numberCategories']}})</span> 
                            <div class="flex flex-col">
                                @if($stats['numberCategories'] > 0)
                                    <select class="text-end" multiple>                              
                                        @foreach ($stats['categories'] as $category)                            
                                            <option value="">{{$category}}</option>
                                        @endforeach
                                    </select>    
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                @endif
                
            </div>  
            @endif
    

            <!-- TABLE ENTRIES HEADER AND BULK ACTIONS -->
            @if($total > 0)

                <div class="flex flex-row justify-between md:items-end bg-red-600 text-white mt-4">

                    <!-- Entries Found -->
                    <div class="p-2">
                        <span class="text-lg">Entries Found ({{ $search != '' ? $found : $total }})</span>
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
                                    value="{{ $entriesRaw->pluck('id') }}">
                                <input type="hidden" id="criteriaSelection" name="criteriaSelection"
                                    value="{{ json_encode($this->criteria) }}">
                                <input type="hidden" id="entryType" name="entryType"
                                    value="archive">                   
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
                                <!-- Restore -->
                                <a wire:click.prevent="bulkRestore" wire:confirm="Restore this entries?"
                                    title="Restore"
                                    class="cursor-pointer text-black hover:text-green-400 transition duration-1000 ease-in-out">
                                    <span><i class="fa-sm fa-solid fa-rotate-right"></i></span>
                                    <span>({{ count($selections) }})</span>
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
                                        <input type="hidden" id="criteriaSelection" name="criteriaSelection"
                                            value="{{ json_encode($this->criteria) }}">    
                                        <input type="hidden" id="entryType" name="entryType"
                                            value="archive">
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
               

            @if ($entries->count())
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
                                    <th wire:click="sorting('user_id')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'user_id' ? 'text-yellow-400' : '' }}">
                                        User {!! $sortLink !!}</th>
                                    <th wire:click="sorting('date')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'date' ? 'text-yellow-400' : '' }}">
                                        Date {!! $sortLink !!}</th>
                                    @if(!$smallView)
                                    <th wire:click="sorting('title')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'title' ? 'text-yellow-400' : '' }}">
                                        Title {!! $sortLink !!}</th>
                                    @endif
                                    <th wire:click="sorting('company')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'company' ? 'text-yellow-400' : '' }}">
                                        Company {!! $sortLink !!}</th>
                                    <!-- <th wire:click="sorting('entries.type')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-black {{ $column == 'type' ? 'text-black' : '' }}">
                                        type {!! $sortLink !!}</th> -->
                                    <th wire:click="sorting('value')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'value' ? 'text-yellow-400' : '' }}">
                                        Value <span class="text-sm">(€)</span> {!! $sortLink !!}</th>
                                    <th wire:click="sorting('frequency')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'frequency' ? 'text-yellow-400' : '' }}">
                                        Frequency {!! $sortLink !!}</th>
                                    <th wire:click="sorting('balance_source')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'balance_source' ? 'text-yellow-400' : '' }}">
                                        payment {!! $sortLink !!}</th>
                                    <th wire:click="sorting('balance_name')" scope="col"
                                            class="p-2 hover:cursor-pointer {{ $column == 'balance_name' ? 'text-yellow-400' : '' }}">
                                            account {!! $sortLink !!}</th>
                                    <th wire:click="sorting('category_name')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'category_name' ? 'text-yellow-400' : '' }}">
                                        category {!! $sortLink !!}</th>
                                    @if(!$smallView)
                                        <th scope="col" class="p-2 text-center">tags</th>                                    
                                        <th scope="col" class="text-center">Files</th>
                                    @endif
                                    <th scope="col" class="p-2 text-center">actions</th>
                                </tr>
                            </thead>
                            <!-- TABLE BODY -->
                            <tbody>
                                @foreach ($entries as $entry)
                                    <tr
                                        class="text-black {{$smallFont ? 'text-xs' : 'text-sm'}} leading-6 {{in_array($entry->id, $okselections) ? 'bg-green-200' : 'even:bg-zinc-100 odd:bg-zinc-50'}} transition-all duration-1000 hover:bg-yellow-200">
                                                
                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ intval($entry->id) }} 
                                                id={{ $entry->id }}
                                                {{ in_array($entry->id, $selections) ? 'checked' : '' }}
                                                >
                                        </td>
                                        <td class="p-2 pr-12 {{ $column == 'id' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $entry->id }}</td>
                                        <td class="p-2 pr-12 {{ $column == 'user_id' ? 'bg-yellow-400 font-bold text-slate-800 transition-all duration-1000' : '' }}">{{ $entry->user->name }}</td>
                                        <td class="p-2 pr-12 {{ $column == 'date' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ date('d-m-Y', strtotime($entry->date)) }}</td>
                                        @if(!$smallView)
                                        <td class="p-2 pr-12 {{ $column == 'title' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}"> {{ $entry->title }}</td>
                                        @endif
                                        <!-- <td class="p-2">{{ $entry->type == 0 ? 'G' : 'I' }}</td> -->
                                        <td class="p-2 pr-12 {{ $column == 'company' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}"> <a
                                                href="{{ route('entries.show', $entry) }}">{{ $entry->company }}</a>
                                        </td>
                                        <td class="p-2 pr-16 {{ $column == 'value' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }} {{ $entry->type == 0 ? 'text-red-600' : 'text-green-600' }}">{{ $entry->value }}</td>
                                        <td class="p-2 pr-12 {{ $column == 'frequency' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $entry->frequency }}</td>
                                        <td class="p-2 pr-16 {{ $column == 'balance_source' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $entry->balance_source }}</td>                                                                                
                                        <td class="p-2 pr-12 {{ $column == 'balance_name' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $entry->balance_name }}</td>
                                        <td class="p-2 pr-12 {{ $column == 'category_name' ? 'bg-yellow-400 font-bold text-black transition-all duration-1000' : '' }}">{{ $entry->category_name }}</td>
                                        @if(!$smallView)
                                        <td class="p-2">
                                            @foreach ($entry->tags as $tags)
                                                {{$tags->name}} 
                                            @endforeach
                                        </td>         
                                        @endif                               
                                        @if(!$smallView)
                                        <td class="text-sm text-black p-2">
                                            <div class="flex flex-col justify-between items-center gap-2">                                                
                                                @foreach ($entry->files as $file)
                                                    @include('partials.mediatypes-file', [
                                                        'file' => $file,
                                                        'iconSize' => 'fa-lg',
                                                        'imagesBig' => false,
                                                    ])
                                                @endforeach
                                            </div>
                                        </td>
                                        @endif
                                        <!-- ACTIONS --> 
                                        <td class="p-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <!-- Show -->
                                                <a href="{{ route('archive.show', $entry->id) }}" title="Show">
                                                    <i
                                                        class="fa-solid fa-circle-info text-orange-600 hover:text-orange-700 transition duration-1000 ease-in-out"></i>
                                                </a>      
                                                <!-- Restore -->                                                 
                                                <form action="{{ route('archive.restore', $entry->id) }}" method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('PUT')
                                                    <button   
                                                        onclick="return confirm('Entry with (ID: {{  $entry->id }}) will be restored')"                                                     
                                                        title="Restore">                                                        
                                                        <i
                                                        class="fa-solid fa-rotate-right text-green-600 hover:text-green-700 transition duration-1000 ease-in-out"></i>
                                                    </button>
                                                </form>                                         
                                                <!-- Delete -->
                                                <form action="{{ route('archive.destroy', $entry) }}" method="POST">
                                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                @csrf
                                                <!-- Dirtective to Override the http method -->
                                                @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Delete PERMANENTLY Entry with (ID: {{  $entry->id }})?')"                                                        
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
                    <span>No entries found in the system.</span>
                    <a wire:click.prevent="resetAll" title="Reset">
                        <i
                            class="fa-lg fa-solid fa-circle-xmark cursor-pointer px-2 text-red-600 hover:text-red-400 transition duration-1000 ease-in-out"></i>
                    </a>
                    </span>
                </div>            
            @endif       


            <!-- Pagination Links -->
            <div class="py-2 px-4">
                {{ $entries->links() }}
            </div>

            <!-- To the Top Button -->
            <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                    class="fa-solid fa-angle-up"></i></button>                    

    </div>

    <!-- Footer -->
    <div class="flex flex-row justify-center items-center p-2 mt-4 bg-red-600 rounded-sm">
        <span class="font-bold text-xs text-white">xavulankis 2025</span>
    </div>

</div>



