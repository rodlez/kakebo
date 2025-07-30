<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
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
            <div
                class="flex flex-row justify-between items-center py-2 mx-4 mt-2 border-green-600 border-b-2 w-100 sm:w-100">
                <div>
                    <span class="px-2 text-lg text-zinc-800">Filters</span>
                </div>
                <!-- Open/Close Buttons -->
                 <div>
                    @if ($showFilters % 2 != 0)
                        <a wire:click="activateFilter" class="cursor-pointer tooltip">
                            <i class="fa-solid fa-minus"></i>
                            <!-- <span class="tooltiptext">Close</span> -->
                        </a>
                    @else
                        <a wire:click="activateFilter" class="cursor-pointer tooltip">
                            <i class="fa-solid fa-plus"></i>
                            <!-- <span class="tooltiptext">Open</span> -->
                        </a>
                    @endif
                </div> 

                {{-- 
                // TODO: SHOW HIDE
                <div>
                    <button onclick="showHide()" id="botonini">Show</button>
                </div> --}}
            </div>

            @if ($showFilters % 2 != 0) 
            <div id="filtrini" class="text-black bg-gray-200 rounded-lg mx-4 my-2 py-2 w-100">

                <!-- Types -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2">
                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-yellow-600 fa-lg fa-solid fa-circle-check"></i></span>
                        <span class="px-2">Types</span>
                    </div>
                    <div class="flex flex-row items-center w-full md:w-1/2 md:text-start">
                        <select wire:model.live="types" class="rounded-lg w-full md:w-80">
                            <option value="2">All</option>
                            <option value="0">0 - Gasto</option>
                            <option value="1">1 - Ingreso</option>
                        </select>
                        @if ($types != 2)
                            <a wire:click.prevent="clearFilterTypes" title="Reset Filter" class="cursor-pointer">
                                <span class="text-red-600 hover:text-red-400 px-2"><i
                                        class="fa-solid fa-circle-xmark"></i></span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Date -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2 ">

                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-violet-600 fa-lg fa-solid fa-calendar-days"></i></span>
                        <span class="px-2">Date</span>
                    </div>

                    <div class="flex flex-col justify-start items-start w-full md:w-1/2 md:text-start">
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">From</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="date" class="rounded-lg w-full" placeholder="From"
                                    wire:model.live="dateFrom">
                                @if ($initialDateFrom != $dateFrom)
                                    <a wire:click.prevent="clearFilterDate" title="Reset Filter" class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">To</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="date" class="rounded-lg w-full" placeholder="To"
                                    wire:model.live="dateTo">
                                @if ($initialDateTo != $dateTo)
                                    <a wire:click.prevent="clearFilterDate" title="Reset Filter" class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <!-- Filter Error Date -->
                        <div>
                            @if ($dateTo < $dateFrom)
                                <span class="text-sm text-red-600 px-2">To must be bigger than From</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Value -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2 ">

                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-emerald-600 fa-lg fa-solid fa-route"></i></span>
                        <span class="px-2">Value <span class="text-xs">(€)</span></span>
                    </div>

                    <div class="flex flex-col justify-start items-start w-full md:w-1/2 md:text-start">
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">From</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="number" class="rounded-lg w-full" placeholder="From"
                                    wire:model.live="valueFrom">
                                @if ($initialValueFrom != $valueFrom)
                                    <a wire:click.prevent="clearFilterValue" title="Reset Filter"
                                        class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">To</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="number" class="rounded-lg w-full" placeholder="To"
                                    wire:model.live="valueTo">
                                @if ($initialValueTo != $valueTo)
                                    <a wire:click.prevent="clearFilterValue" title="Reset Filter"
                                        class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <!-- Filter Error Value -->
                        <div>
                            @if ($valueTo < $valueFrom)
                                <span class="text-sm text-red-600 px-2">To must be bigger than From</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Company -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2">
                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-yellow-600 fa-lg fa-solid fa-sitemap"></i></span>
                        <span class="px-2">Company (<span
                                class="font-semibold text-sm">{{ $companies->count() }}</span>)</span>
                    </div>
                    <div class="flex flex-row items-center w-full md:w-1/2 md:text-start">
                        <select wire:model.live="compa" class="rounded-lg w-full md:w-80">
                            <option value="0">All</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->company }}">{{ $company->company }}</option>
                            @endforeach
                        </select>
                        @if ($compa != '')
                            <a wire:click.prevent="clearFilterCompany" title="Reset Filter" class="cursor-pointer">
                                <span class="text-red-600 hover:text-red-400 px-2"><i
                                        class="fa-solid fa-circle-xmark"></i></span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Category -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2">
                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-yellow-600 fa-lg fa-solid fa-sitemap"></i></span>
                        <span class="px-2">Category (<span
                                class="font-semibold text-sm">{{ $categories->count() }}</span>)</span>
                    </div>
                    <div class="flex flex-row items-center w-full md:w-1/2 md:text-start">
                        <select wire:model.live="cat" class="rounded-lg w-full md:w-80">
                            <option value="0">All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($cat > 0)
                            <a wire:click.prevent="clearFilterCategory" title="Reset Filter" class="cursor-pointer">
                                <span class="text-red-600 hover:text-red-400 px-2"><i
                                        class="fa-solid fa-circle-xmark"></i></span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Tag -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2">
                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-yellow-600 fa-lg fa-solid fa-sitemap"></i></span>
                        <span class="px-2">Tag (<span
                                class="font-semibold text-sm">{{ $tags->count() }}</span>)</span>
                    </div>
                    <div class="flex flex-row items-center w-full md:w-1/2 md:text-start">
                        <select wire:model.live="tag" class="rounded-lg w-full md:w-80">
                            <option value="0">All</option>
                            @foreach ($tags as $taged)
                                <option value="{{ $taged->id }}">{{ $taged->name }}</option>
                            @endforeach
                        </select>
                        @if ($tag > 0)
                            <a wire:click.prevent="clearFilterTag" title="Reset Filter" class="cursor-pointer">
                                <span class="text-red-600 hover:text-red-400 px-2"><i
                                        class="fa-solid fa-circle-xmark"></i></span>
                            </a>
                        @endif
                    </div>
                </div>
            
            <!-- End Filters -->
            </div>
            @endif        

            <!-- Search -->
            <div class="flex flex-col sm:flex-row justify-between items-start px-2 sm:px-4 py-4 gap-4">
                <!-- Search -->
                <div class="relative w-full">
                    <div class="absolute top-0.5 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input wire:model.live="search" type="search"
                        class="w-full rounded-lg pl-10 font-sm placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-orange-400 border-2 border-zinc-200"
                        placeholder="Search by name">
                </div>
                <!-- Pagination -->
                <div class="relative w-32">
                    <div class="absolute top-0 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <select wire:model.live="perPage"
                        class="w-full rounded-lg text-end focus:outline-none focus:ring-0 focus:border-orange-400 border-2 border-zinc-200 ">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <!-- Bulk Actions -->
            @if (count($selections) > 0)
                <div class="px-2 sm:px-4">
                    <div class="flex flex-row justify-start items-center gap-4 py-2 px-4 mb-2 rounded-lg bg-zinc-200">
                        <span class="text-sm font-semibold">Bulk Actions</span>
                        <a wire:click.prevent="bulkClear" class="cursor-pointer" title="Unselect All">
                            <span><i class="fa-solid fa-rotate-right text-green-600 hover:text-green-500"></i></span>
                        </a>
                        <a wire:click.prevent="bulkDelete" wire:confirm="Are you sure you want to delete this items?"
                            class="cursor-pointer text-red-600 hover:text-red-500" title="Delete">
                            <span><i class="fa-sm fa-solid fa-trash"></i></span>
                            <span>({{ count($selections) }})</span>
                        </a>
                    </div>
                </div>
            @endif
            <!-- TABLE -->
            <div class="px-0 sm:px-4 pb-0 ">
                <div class="overflow-x-auto">

                    @if ($entries->count())
                        <table class="min-w-full ">
                            <!-- TABLE HEADER -->
                            <thead>
                                <tr class="text-black text-left text-sm font-normal uppercase">
                                    <th></th>                                    
                                    <th wire:click="sorting('entries.id')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-orange-600 {{ $column == 'id' ? 'text-orange-600' : '' }}">
                                        id {!! $sortLink !!}</th>
                                    <th wire:click="sorting('entries.date')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-orange-600 {{ $column == 'date' ? 'text-orange-600' : '' }}">
                                        date {!! $sortLink !!}</th>
                                    <th wire:click="sorting('entries.title')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-orange-600 {{ $column == 'title' ? 'text-orange-600' : '' }}">
                                        title {!! $sortLink !!}</th>
                                    <!-- <th wire:click="sorting('entries.type')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-orange-600 {{ $column == 'type' ? 'text-orange-600' : '' }}">
                                        type {!! $sortLink !!}</th> -->
                                    <th wire:click="sorting('entries.value')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-orange-600 {{ $column == 'value' ? 'text-orange-600' : '' }}">
                                        value (€) {!! $sortLink !!}</th>
                                    <th wire:click="sorting('entries.company')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-orange-600 {{ $column == 'company' ? 'text-orange-600' : '' }}">
                                        company {!! $sortLink !!}</th>                                    
                                    <th scope="col" class="p-2 text-center capitalize">category</th>
                                    <th scope="col" class="p-2 text-center capitalize">tags</th>
                                    <th scope="col" class="capitalize text-center">Files</th>
                                    <th scope="col" class="p-2 text-center capitalize">actions</th>
                                </tr>
                            </thead>
                            <!-- TABLE BODY -->
                            <tbody>
                                @foreach ($entries as $entry)
                                    <tr
                                        class="text-black text-sm leading-6 even:bg-zinc-200 odd:bg-gray-300 transition-all duration-1000 hover:bg-orange-400">
                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ $entry->id }}></td>
                                        <td class="p-2">{{ $entry->id }}</td>
                                        <td class="p-2">{{ date('d-m-Y', strtotime($entry->date)) }}</td>
                                        <td class="p-2"> <a
                                                href="{{ route('entries.show', $entry) }}">{{ $entry->title }}</a>
                                        </td>
                                        <!-- <td class="p-2">{{ $entry->type == 0 ? 'G' : 'I' }}</td> -->
                                        <td class="p-2 {{ $entry->type == 0 ? 'text-red-600' : 'text-green-600' }}">{{ $entry->value }}</td>
                                        <td class="p-2">{{ $entry->company }}</td>                                        
                                        <td class="p-2">{{ $entry->category->name }}</td>
                                        <td class="p-2">
                                            @foreach ($entry->tags as $tags)
                                                {{$tags->name}} 
                                            @endforeach
                                        </td>                                        
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
                            <a wire:click.prevent="clearSearch" title="Reset">
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



