<div class="max-w-7xl mx-auto {{$isAdmin ? 'bg-slate-300' : 'bg-white'}} sm:pb-8 sm:px-6 lg:px-8">
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/entries" class="font-bold text-black border-b-2 border-b-orange-600">Entries</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <div>
            <!-- Header -->
            <div class="flex flex-row justify-between items-center py-4 bg-orange-400">
                <div>
                    <span class="text-lg text-white px-4">Entries <span
                            class="text-sm">({{ $search != '' ? $found : $total }})</span></span>
                </div>
                <div class="px-4">
                    <a href="{{ route('entries.create') }}"
                        class="text-white text-sm sm:text-md rounded-lg py-2 px-4 bg-black hover:bg-gray-600 transition duration-1000 ease-in-out"
                        title="Create New Tag">New</a>
                </div>
            </div>


            <!-- FILTERS-->
            <div class="flex flex-col w-11/12 mx-auto my-4">
                
                <div class="flex flex-row justify-between items-center w-full border-b-2 border-b-green-800">
                    <span class="font-bold uppercase bg-green-800 rounded-sm text-white py-2 px-3  my-1">
                        <a wire:click="activateFilter" class="cursor-pointer" title="{{($showFilters % 2 != 0) ? 'Close Filters' : 'Open Filters'}}">filters</a>
                    </span>
                    <!-- Open/Close Buttons -->
                    <div>
                        @if ($showFilters % 2 != 0)
                            <a wire:click="activateFilter" class="cursor-pointer" title="Close Filters">
                                <i class="text-red-800 fa-solid fa-xmark"></i>
                            </a>
                        @else
                            <a wire:click="activateFilter" class="cursor-pointer" title="Open Filters">
                                <i class="text-green-800 fa-solid fa-caret-down"></i>
                            </a>
                        @endif
                    </div>
                </div>

                @if ($showFilters % 2 != 0)
                <!-- Filters Options -->    
                <div class="flex flex-col bg-green-800 opacity-95 py-2 my-1 rounded-sm text-white">

                    @if ($isAdmin)
                    <!-- 2 ROW FILTER -->

                    <div class="flex flex-row p-1 my-1">
                        <!-- USERS -->
                        <div class="flex flex-row justify-between w-1/2">                    
                        
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-user"></i></span>
                                <span class="px-2">Users (<span
                                        class="font-semibold text-sm">{{ $users->count() }}</span>)</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="userID" class="w-full rounded-sm bg-gray-100 text-end text-green-800">
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
                    <div class="flex flex-row p-1 my-1">
                        <!-- TYPES -->
                        <div class="flex flex-row justify-between w-1/2">
                            
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-wallet"></i></span>
                                <span class="px-2">Types</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="types" class="w-full rounded-sm bg-gray-100 text-end text-green-800">
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
                        <div class="flex flex-row justify-between w-1/2">
                                
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-clock"></i></span>
                                <span class="px-2">Frequency (<span
                                    class="font-semibold text-sm">{{ $frequencies->count() }}</span>)</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="freq" class="w-full rounded-sm bg-gray-100 text-end text-green-800">
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
                    <div class="flex flex-row p-1 my-1">
                        <!-- Source -->
                        <div class="flex flex-row justify-between w-1/2">
                            
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-money-bill"></i></span>
                                <span class="px-2">Source (<span
                                class="font-semibold text-sm">{{ $sources->count() }}</span>)</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="sour" class="w-full rounded-sm bg-gray-100 text-end text-green-800">
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
                        <div class="flex flex-row justify-between w-1/2">
                                
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-piggy-bank"></i></span>
                                <span class="px-2">Balance (<span
                                class="font-semibold text-sm">{{ $balances->count() }}</span>)</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="bal" class="w-full rounded-sm bg-gray-100 text-end text-green-800">
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
                    <div class="flex flex-row p-1 my-1">
                        <!-- Company -->
                        <div class="flex flex-row justify-between w-1/2">
                            
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-industry"></i></span>
                                <span class="px-2">Company (<span
                                class="font-semibold text-sm">{{ $companies->count() }}</span>)</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="compa" class="w-full rounded-sm bg-gray-100 text-end text-green-800">
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
                        <div class="flex flex-row justify-between w-1/2">
                                
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-tag"></i></span>
                                <span class="px-2">Category (<span
                                class="font-semibold text-sm">{{ count($categories) }}</span>)</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="cat" class="w-full rounded-sm bg-gray-100 text-end text-green-800">
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
                    <div class="flex flex-row p-1 my-1">
                        <!-- Date From -->
                        <div class="flex flex-row justify-between w-1/2">
                            
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-calendar"></i></span>
                                <span class="px-2">Date <span class="text-sm font-bold">from</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <input type="date" class="w-full rounded-sm bg-gray-100 text-end text-green-800" placeholder="From"
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
                        <div class="flex flex-row justify-between w-1/2">
                            
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-calendar"></i></span>
                                <span class="px-2">Date <span class="text-sm font-bold">to</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <input type="date" class="w-full rounded-sm bg-gray-100 text-end text-green-800" placeholder="From"
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
                    @if ($dateTo < $dateFrom)
                    <div class="flex flex-col bg-gray-200 w-full">
                        <span class="text-sm text-red-600 px-2"> Date To must be bigger than Date From</span>
                    </div>
                    @endif


                    <!-- 2 ROW FILTER VALUE-->
                    <div class="flex flex-row p-1 my-1">
                        <!-- Value From -->
                        <div class="flex flex-row justify-between w-1/2">
                            
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-eur"></i></span>
                                <span class="px-2">Value <span class="text-sm font-bold">from</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <input type="number" class="w-full rounded-sm bg-gray-100 text-end text-green-800" placeholder="From"
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
                        <div class="flex flex-row justify-between w-1/2">
                            
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-eur"></i></span>
                                <span class="px-2">Value <span class="text-sm font-bold">to</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <input type="number" class="w-full rounded-sm bg-gray-100 text-end text-green-800" placeholder="From"
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
                    @if ($valueTo < $valueFrom)
                    <div class="flex flex-col bg-gray-200 w-full">
                        <span class="text-sm text-red-600 px-2"> Value To must be bigger than Value From</span>
                    </div>
                    @endif
                    


                    <!-- 1 ROW FILTER -->
                    <div class="flex flex-row p-1 my-1">
                        <!-- TAGS -->
                        <div class="flex flex-row justify-between w-1/2">
                        
                            <div class="w-5/12">
                                <span><i class="text-white fa fa-tags"></i></span>
                                <span class="px-2">Tags (<span
                                    class="font-semibold text-sm">{{ count($tags) }}</span>)</span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end ml-1">                            
                                <select wire:model.live="selectedTags" class="w-full rounded-sm bg-gray-100 text-end text-green-800 px-4" name="selectedTags" id="selectedTags" multiple>
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
            
            <!-- Search Type-->
            <div class="flex flex-col w-11/12 mx-auto">

                <div class="flex flex-row justify-between items-center w-full border-b-2 border-b-blue-800">
                    <span class="font-bold uppercase bg-blue-800 rounded-sm text-white py-2 px-3  my-1">
                        <a wire:click="activateSearch" class="cursor-pointer" title="{{($showSearch % 2 != 0) ? 'Close Search' : 'Open Search'}}">search</a>
                    </span>
                    <!-- Open/Close Buttons -->
                    <div>
                        @if ($showSearch % 2 != 0)
                            <a wire:click="activateSearch" class="cursor-pointer" title="Close Search">
                                <i class="text-red-800 fa-solid fa-xmark"></i>
                            </a>
                        @else
                            <a wire:click="activateSearch" class="cursor-pointer" title="Open Search">
                                <i class="text-blue-800 fa-solid fa-caret-down"></i>
                            </a>
                        @endif
                    </div>
                </div>

                @if ($showSearch % 2 != 0)

                <div class="flex flex-col bg-blue-800 py-2 my-1 rounded-sm">

                    <div class="flex flex-row gap-2 text-sm w-full mb-0">
                        <div class="flex flex-row w-2/12 bg-blue-100 rounded-sm p-2 ml-2 items-center gap-2">
                            <i class="fa-solid fa-text-width"></i>
                            <span class="capitalize">title</span>    
                            <input type="radio" wire:model.live="searchType" value="title" class="cursor-pointer">
                        </div>
                        <div class="flex flex-row w-2/12 bg-blue-100 rounded-sm p-2 items-center gap-2">
                            <i class="fa-solid fa-industry"></i>
                            <span class="capitalize">company</span>    
                            <input type="radio" wire:model.live="searchType" value="company" class="cursor-pointer">
                        </div>
                        <div class="flex flex-row w-2/12 bg-blue-100 rounded-sm p-2 items-center gap-2">
                            <i class="fa-solid fa-piggy-bank"></i>
                            <span class="capitalize">account</span>    
                            <input type="radio" wire:model.live="searchType" value="balances.name" class="cursor-pointer">
                        </div>         
                    </div>
                    <!-- Search Word -->
                    <div class="relative w-full p-2">
                        <div class="absolute top-3 bottom-0 left-4 text-gray-600">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input wire:model.live="search" type="search"
                            class="w-full bg-gray-100 rounded-sm pl-8 py-1 text-sm placeholder-gray-600 focus:outline-none focus:ring-0 focus:border-blue-400 border-2 border-blue-800"
                            placeholder="Search by {{ ($searchType == 'balances.name') ? 'account' : $searchType }}">
                        @if ($search != '')
                        <div class="absolute top-3 bottom-0 right-4 text-slate-700">
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



  
            
            <!-- Criteria
            {{ var_dump($criteria) }}
            Total
            {{ count($criteria)}}
            Search
            {{ $search }} -->
            <!-- Criteria -->
            
            @if (count($criteria) > 0)

                <!-- Criteria Type-->
                <div class="flex flex-col w-11/12 mx-auto py-2">
                    <div class="flex flex-row justify-between items-center w-full border-b-2 border-b-orange-400">
                        <span class="italic capitalize bg-orange-400 rounded-sm text-white py-2 px-3  my-1">
                            filters & search criteria
                        </span>
                        <!-- Clear ALL Criteria for search and filters -->
                        <div>
                            <a wire:click.prevent="resetAll" title="Clear All">
                                <i class="fa-lg fa-solid fa-square-xmark text-red-600 hover:text-black cursor-pointer"></i>
                            </a>
                        </div>
                    </div>              




                

                <div class="flex flex-col bg-gray-300 py-2 my-1 rounded-sm">

                    <div class="flex flex-wrap text-xs capitalize w-full p-2 gap-3 sm:gap-4">
                        <!-- Search -->
                        @if ($search != '')
                            <div class="flex relative">                                
                                <div
                                    class="bg-blue-200 p-2 rounded-sm border-2 border-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <span class="uppercase font-bold">search</span>
                                    <span class="italic">({{ $criteria['searchType'] }})</span>
                                </div>
                                <a wire:click.prevent="clearSearch" title="Clear Search" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- User -->
                        @if ($userID > 0)
                            <div class="flex relative">                                
                                <div
                                    class="bg-green-200 p-2 rounded-sm border-2 border-white">
                                    <i class="fa-solid fa-user"></i>
                                    <span class="uppercase font-bold">user</span>
                                    <span class="italic">({{ $criteria['user'] }})</span>
                                </div>
                                <a wire:click.prevent="clearFilterUser" title="Clear Filter User" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Types -->
                        @if ($types != 2)
                        <div class="flex relative">                                
                                <div
                                    class="bg-green-200 p-2 rounded-sm border-2 border-white">
                                    <i class="fa-solid fa-wallet"></i>
                                    <span class="uppercase font-bold">type</span>
                                    <span class="italic">({{ $types == 1 ? 'income' : 'expense' }})</span>
                                </div>
                                <a wire:click.prevent="clearFilterTypes" title="Clear Filter Type" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>                            
                        @endif
                        <!-- Date -->
                        @if ($initialDateTo != $dateTo || $initialDateFrom != $dateFrom)
                            <div class="flex relative">
                                <span
                                    class="bg-violet-400 p-2 rounded-lg">{{ $initialDateTo != $dateTo || $initialDateFrom != $dateFrom ? 'Date (' . date('d-m-Y', strtotime($dateFrom)) . ' to ' . date('d-m-Y', strtotime($dateTo)) . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterDate" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Category -->
                        @if ($cat > 0)
                            <div class="flex relative">
                                <span
                                    class="bg-yellow-600 opacity-75 p-2 rounded-lg">{{ $cat > 0 ? 'Category (' . $cat . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterCategory" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Balance -->
                        @if ($bal > 0)
                            <div class="flex relative">
                                <span
                                    class="bg-yellow-600 opacity-75 p-2 rounded-lg">{{ $bal > 0 ? 'Account (' . $bal . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterBalance" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Tags -->
                        @if (!in_array('0', $this->selectedTags) && count($this->selectedTags) != 0)
                            <div class="flex relative">
                                <span
                                    class="bg-orange-600 opacity-75 p-2 rounded-lg">{{ !in_array('0', $this->selectedTags) && count($this->selectedTags) != 0 ? 'Tags (' . implode(', ', $tagNames) . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterTag" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Value -->
                        @if ($initialValueTo != $valueTo || $initialValueFrom != $valueFrom)
                            <div class="flex relative">
                                <span
                                    class="bg-blue-600 opacity-75 p-2 rounded-lg">{{ $initialValueTo != $valueTo || $initialValueFrom != $valueFrom ? 'Value (' . $valueFrom . ' to ' . $valueTo . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterValue" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif   
                        <!-- Frequency -->
                        @if ($freq != 0)
                            <div class="flex relative">
                                <span
                                    class="bg-green-600 opacity-75 p-2 rounded-lg">{{ $freq != 0 ? 'Frequency (' . $freq . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterFrequency" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif  
                        <!-- Source -->
                        @if ($sour != 0)
                            <div class="flex relative">
                                <span
                                    class="bg-green-600 opacity-75 p-2 rounded-lg">{{ $sour != 0 ? 'Source (' . $sour . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterSource" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif 
                        <!-- Company -->
                        @if ($compa != 0)
                            <div class="flex relative">
                                <span
                                    class="bg-green-600 opacity-75 p-2 rounded-lg">{{ $compa != 0 ? 'Company (' . $compa . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterCompany" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif                    

                    </div>

                </div>

                </div>
            @endif

            <!-- Bulk Actions -->
            @if (count($okselections) > 0)
            <!-- <div> selections -> {{ var_dump($selections)}}</div>
            <div>listEntriesIds -> {{ var_dump($listEntriesIds)}}</div>
            <div>okselections -> {{ var_dump($okselections)}}</div> -->
                <div class="px-2 sm:px-4 pt-1">
                    <div class="flex flex-row justify-start items-center gap-4 py-1 px-4 mb-0 rounded-lg bg-zinc-200">
                        <span class="text-sm font-semibold">Bulk Actions</span>
                        <a wire:click.prevent="bulkClear" class="cursor-pointer" title="Unselect All">
                            <span><i class="fa-solid fa-rotate-right text-green-600 hover:text-green-500"></i></span>
                        </a>
                        <a wire:click.prevent="bulkDelete" wire:confirm="Are you sure you want to delete this items?"
                            class="cursor-pointer text-red-600 hover:text-red-500" title="Delete">
                            <span><i class="fa-sm fa-solid fa-trash"></i></span>
                            <span>({{ count($okselections) }})</span>
                        </a>

                        <form action="{{ route('entries.exportbulk') }}" method="POST">
                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                @csrf
                                <input type="hidden" id="listEntriesBulk" name="listEntriesBulk"
                                    value="{{ implode(',', $okselections) }}">
                                <button class="cursor-pointer text-blue-600" title="Export Selection">
                                    <i class="fa-solid fa-file-export"></i>
                                </button>
                        </form>

                    </div>
                </div>
            @endif

            @if($total > 0)
            <!-- Export -->
            <div class="flex flex-row justify-between items-end sm:flex-row sm:justify-between gap-2 pt-0 mt-2 px-0 mx-4 border-2 border-yellow-600">

                <!-- Entries Found -->
                <div class="flex flex-row p-2 font-bold">Entries Found ({{ $search != '' ? $found : $total }})</div>

                <div class="flex flex-row p-0">

                    <!-- Normal or Full View of the information in the Entries Table -->            
                    <div class="flex flex-row sm:flex-row justify-begin items-end px-4 sm:px-4 py-2 gap-2 text-xs">
                        
                        <div class="pl-2">
                            <a wire:click="activateFullView({{0}})" class="{{($fullView === false) ? 'font-bold' : 'text-gray-400'}} cursor-pointer"> 
                                <span class="">Normal View </span> <i class="fa-solid fa-eye"></i>                            
                            </a>
                        </div>
                    
                        <div>
                            <a wire:click="activateFullView({{1}})" class="{{($fullView === true) ? 'font-bold' : 'text-gray-400'}} cursor-pointer">
                                <span class="">Full View </span> <i class="fa-solid fa-maximize"></i>                           
                            </a>
                        </div>
                        
                    </div>
                
                    <!-- Export ALL Entries found as Excel file -->
                    <div class="flex flex-row gap-2 items-end pb-2 mr-2">
                        <form action="{{ route('entries.export') }}" method="POST">
                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                @csrf
                                <input type="hidden" id="entries" name="entries"
                                    value="{{ $entriesRaw->pluck('id') }}">
                                <input type="hidden" id="criteriaSelection" name="criteriaSelection"
                                    value="{{ json_encode($this->criteria) }}">
                                <button
                                    class="text-white text-sm sm:text-md rounded-md p-1 bg-green-600 hover:bg-green-400 transition duration-1000 ease-in-out cursor-pointer"
                                    title="Export All as Excel file">
                                    <i class="fa-solid fa-file-export"></i>
                                </button>
                        </form>
                    </div>
                
                </div>
                
            </div>    
            @endif    
           

            <!-- Pagination -->
                <div class="relative w-32">
                    <div class="absolute top-0 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <select wire:model.live="perPage"
                        class="w-full rounded-lg text-end focus:outline-none focus:ring-0 focus:border-blue-400 border-2 border-zinc-200 ">
                        <option value="3">3</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

            <!-- TABLE -->
            <div class="px-0 sm:px-4 pb-0">
                <div class="overflow-x-auto">

                    @if ($entries->count())
                        <table class="min-w-full ">
                            <!-- TABLE HEADER -->
                            <thead>
                                <tr class="text-black text-left text-sm font-normal capitalize">
                                    <th></th>                                    
                                    <th wire:click="sorting('id')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'entries.id' ? 'text-orange-600' : '' }}">
                                        id {!! $sortLink !!}</th>
                                    @if($isAdmin)
                                    <th wire:click="sorting('user_id')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'entries.user_id' ? 'text-orange-600' : '' }}">
                                        User {!! $sortLink !!}</th>
                                    @endif
                                    <th wire:click="sorting('date')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'entries.date' ? 'text-orange-600' : '' }}">
                                        Date {!! $sortLink !!}</th>
                                    @if($fullView)
                                    <th wire:click="sorting('title')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'entries.title' ? 'text-orange-600' : '' }}">
                                        Title {!! $sortLink !!}</th>
                                    @endif
                                    <th wire:click="sorting('company')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'entries.company' ? 'text-orange-600' : '' }}">
                                        Company {!! $sortLink !!}</th>
                                    <!-- <th wire:click="sorting('entries.type')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-orange-600 {{ $column == 'type' ? 'text-orange-600' : '' }}">
                                        type {!! $sortLink !!}</th> -->
                                    <th wire:click="sorting('value')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'entries.value' ? 'text-orange-600' : '' }}">
                                        € {!! $sortLink !!}</th>
                                    <th wire:click="sorting('frequency')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'entries.frequency' ? 'text-orange-600' : '' }}">
                                        Frequency {!! $sortLink !!}</th>
                                    <th wire:click="sorting('balance_source')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'balance_source' ? 'text-orange-600' : '' }}">
                                        source {!! $sortLink !!}</th>
                                    @if($fullView)
                                        <th wire:click="sorting('balance_name')" scope="col"
                                            class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'balance_name' ? 'text-orange-600' : '' }}">
                                            account {!! $sortLink !!}</th>
                                    @endif                             
                                    <th wire:click="sorting('category_name')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-slate-600 {{ $column == 'category_name' ? 'text-orange-600' : '' }}">
                                        category {!! $sortLink !!}</th>
                                    @if($fullView)
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
                                        class="text-black text-sm leading-6 even:bg-zinc-200 odd:bg-gray-300 transition-all duration-1000 hover:bg-yellow-400">
                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ intval($entry->id) }} 
                                                id={{ $entry->id }}
                                                {{ in_array($entry->id, $selections) ? 'checked' : '' }}
                                                >
                                        </td>
                                        <td class="p-2 pr-8">{{ $entry->id }}</td>
                                        @if($isAdmin)
                                            <td class="p-2 pr-12">{{ $entry->user->name }}</td>
                                        @endif
                                        <td class="p-2 text-xs">{{ date('d-m-Y', strtotime($entry->date)) }}</td>
                                        @if($fullView)
                                        <td class="p-2"> {{ $entry->title }}</td>
                                        @endif
                                        <!-- <td class="p-2">{{ $entry->type == 0 ? 'G' : 'I' }}</td> -->
                                        <td class="p-2 pr-8"> <a
                                                href="{{ route('entries.show', $entry) }}">{{ $entry->company }}</a>
                                        </td>
                                        <td class="p-2 {{ $entry->type == 0 ? 'text-red-600' : 'text-green-600' }}">{{ $entry->value }}</td>
                                        <td class="p-2 pr-8">{{ $entry->frequency }}</td>
                                        <td class="p-2 pr-10">{{ $entry->balance_source }}</td>                                                                                
                                        @if($fullView)
                                        <td class="p-2 pr-8">{{ $entry->balance_name }}</td>
                                        @endif
                                        <td class="p-2">{{ $entry->category_name }}</td>
                                        @if($fullView)
                                        <td class="p-2">
                                            @foreach ($entry->tags as $tags)
                                                {{$tags->name}} 
                                            @endforeach
                                        </td>         
                                        @endif                               
                                        @if($fullView)
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
                                                <a href="{{ route('entries.show', $entry) }}" title="Show">
                                                    <i
                                                        class="fa-solid fa-circle-info text-orange-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Upload File -->
                                                <a href="{{ route('files.upload', $entry) }}" title="Upload File">
                                                    <span
                                                        class="text-violet-600 hover:text-black transition-all duration-500 tooltip"><i
                                                            class="fa-lg fa-solid fa-file-arrow-up"></i>
                                                        <!-- <span class="tooltiptext">Upload File</span> -->
                                                    </span>
                                                </a>
                                                <!-- Edit -->
                                                <a href="{{ route('entries.edit', $entry) }}" title="Edit">                                                    
                                                    <i
                                                        class="fa-solid fa-pen-to-square text-green-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form action="{{ route('entries.destroy', $entry) }}" method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Are you sure you want to delete the entry: {{ $entry->title }}?')"
                                                        title="Delete this entry">                                                        
                                                        <span
                                                            class="text-red-600 hover:text-black transition-all duration-500"><i
                                                                class="fa-lg fa-solid fa-trash"></i></span>
                                                    </button>
                                                </form>                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div
                            class="flex flex-row justify-between items-center bg-black text-white rounded-lg p-4 mx-2 sm:mx-0">
                            <span>No entries found in the system.</span>
                            <a wire:click.prevent="resetAll" title="Reset">
                                <i
                                    class="fa-lg fa-solid fa-circle-xmark cursor-pointer px-2 text-red-600 hover:text-red-400 transition duration-1000 ease-in-out"></i>
                            </a>
                            </span>
                        </div>
                    @endif

                </div>

            </div>
            <!-- Pagination Links -->
            <div class="py-2 px-4">
                {{ $entries->links() }}
            </div>
            <!-- To the Top Button -->
            <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                    class="fa-solid fa-angle-up"></i></button>
            <!-- Footer -->
            <div class="flex flex-row justify-end items-center py-4 px-4 bg-orange-400 sm:rounded-b-lg">
                <a href="{{ route('dashboard') }}">
                    <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                        title="Go Back"></i>
                </a>
            </div>

            
            





        </div>

    </div>

</div>



