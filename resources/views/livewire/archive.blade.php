<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/archive" class="font-bold text-black border-b-2 border-b-red-600">Archive</a>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <div>
            <!-- Header -->
            <div class="flex flex-row justify-between items-center py-4 bg-red-400">
                <div>
                    <span class="text-lg text-white px-4">Archive <span
                            class="text-sm">({{ $search != '' ? $found : $total }})</span></span>
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
                        </a>
                    @else
                        <a wire:click="activateFilter" class="cursor-pointer tooltip">
                            <i class="fa-solid fa-plus"></i>
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

                <!-- Users -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2">
                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-yellow-600 fa-lg fa-solid fa-sitemap"></i></span>
                        <span class="px-2">Users (<span
                                class="font-semibold text-sm">{{ $users->count() }}</span>)</span>
                    </div>
                    <div class="flex flex-row items-center w-full md:w-1/2 md:text-start">
                        <select wire:model.live="userID" class="rounded-lg w-full md:w-80">
                            <option value="0">All</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @if ($userID > 0)
                            <a wire:click.prevent="clearFilterUser" title="Reset Filter" class="cursor-pointer">
                                <span class="text-red-600 hover:text-red-400 px-2"><i
                                        class="fa-solid fa-circle-xmark"></i></span>
                            </a>
                        @endif
                    </div>
                </div>
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
                            <option value="0">Gastos</option>
                            <option value="1">Ingresos</option>
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
                                            X<i class="fa-solid fa-circle-xmark"></i>
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
                                            X<i class="fa-solid fa-circle-xmark"></i>
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
                                            X<i class="fa-solid fa-circle-xmark"></i>
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
                                            X<i class="fa-solid fa-circle-xmark"></i>
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
                        class="w-full rounded-lg pl-10 font-sm placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-red-400 border-2 border-zinc-200"
                        placeholder="Search by name">
                </div>
                <!-- Pagination -->
                <div class="relative w-32">
                    <div class="absolute top-0 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <select wire:model.live="perPage"
                        class="w-full rounded-lg text-end focus:outline-none focus:ring-0 focus:border-red-400 border-2 border-zinc-200 ">
                        <option value="1">1</option>
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
                        <!-- Unselect -->
                        <a wire:click.prevent="bulkClear" class="cursor-pointer" title="Unselect All">
                            <span><i class="fa-sm fa-solid fa-xmark text-black hover:text-green-400 transition duration-1000 ease-in-out"></i></span>
                        </a>
                        <!-- Restore -->
                        <a wire:click.prevent="bulkRestore" wire:confirm="Restore this entries?"
                            title="Restore"
                            class="cursor-pointer text-black hover:text-green-400 transition duration-1000 ease-in-out">
                            <span><i class="fa-sm fa-solid fa-rotate-right"></i></span>
                            <span>({{ count($selections) }})</span>
                        </a>
                        <!-- Delete -->
                        <a wire:click.prevent="bulkDelete" wire:confirm="This entries will be PERMANENTLY deleted."
                            title="Delete PERMANENTLY"
                            class="cursor-pointer text-black hover:text-red-600 transition duration-1000 ease-in-out">
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
                                        class="p-2 hover:cursor-pointer hover:text-red-600 {{ $column == 'id' ? 'text-red-600' : '' }}">
                                        id {!! $sortLink !!}</th>
                                    <th scope="col" class="p-2 text-center capitalize">user</th>
                                    <th wire:click="sorting('entries.date')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-red-600 {{ $column == 'date' ? 'text-red-600' : '' }}">
                                        date {!! $sortLink !!}</th>
                                    <th wire:click="sorting('entries.title')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-red-600 {{ $column == 'title' ? 'text-red-600' : '' }}">
                                        title {!! $sortLink !!}</th>
                                    <!-- <th wire:click="sorting('entries.type')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-red-600 {{ $column == 'type' ? 'text-red-600' : '' }}">
                                        type {!! $sortLink !!}</th> -->
                                    <th wire:click="sorting('entries.value')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-red-600 {{ $column == 'value' ? 'text-red-600' : '' }}">
                                        value (€) {!! $sortLink !!}</th>
                                    <th wire:click="sorting('entries.company')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-red-600 {{ $column == 'company' ? 'text-red-600' : '' }}">
                                        company {!! $sortLink !!}</th>                                    
                                    <th scope="col" class="p-2 text-center capitalize">category</th>
                                    <th scope="col" class="p-2 text-center capitalize">tags</th>
                                    <th scope="col" class="p-2 text-center capitalize">files</th>
                                    <th scope="col" class="p-2 text-center capitalize">actions</th>
                                </tr>
                            </thead>
                            <!-- TABLE BODY -->
                            <tbody>
                                @foreach ($entries as $archive)
                                    <tr
                                        class="text-black text-sm leading-6 even:bg-zinc-200 odd:bg-gray-300 transition-all duration-1000 hover:bg-yellow-400">
                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ $archive->id }}></td>
                                        <td class="p-2">{{ $archive->id }}</td>
                                        <td class="p-2">{{ $archive->user->name }}</td>
                                        <td class="p-2">{{ date('d-m-Y', strtotime($archive->date)) }}</td>
                                        <td class="p-2"> <a
                                                href="#">{{ $archive->title }}</a>
                                        </td>
                                        <!-- <td class="p-2">{{ $archive->type == 0 ? 'G' : 'I' }}</td> -->
                                        <td class="p-2 {{ $archive->type == 0 ? 'text-red-600' : 'text-green-600' }}">{{ $archive->value }}</td>
                                        <td class="p-2">{{ $archive->company }}</td>                                        
                                        <td class="p-2">{{ $archive->category->name }}</td>
                                        <td class="p-2">
                                            @foreach ($archive->tags as $tags)
                                                {{$tags->name}} 
                                            @endforeach
                                        </td>                                        
                                         <td class="text-sm text-black p-2">
                                            <div class="flex flex-col justify-between items-center gap-2">                                                
                                                @foreach ($archive->files as $file)
                                                    @include('partials.mediatypes-file', [
                                                        'file' => $file,
                                                        'iconSize' => 'fa-lg',
                                                        'imagesBig' => false,
                                                    ])
                                                @endforeach
                                            </div>
                                        </td>
                                        <!-- Actions -->
                                        <td class="p-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <!-- Show -->
                                                <a href="{{ route('archive.show', $archive->id) }}" title="Show">
                                                    <i
                                                        class="fa-solid fa-circle-info text-violet-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Restore -->                                                 
                                                <form action="{{ route('archive.restore', $archive->id) }}" method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('PUT')
                                                    <button   
                                                        onclick="return confirm('Entry with (ID: {{  $archive->id }}) will be restored')"                                                     
                                                        title="Restore">                                                        
                                                        <span
                                                            class="text-green-600 hover:text-black transition-all duration-500"><i
                                                                class="fa-solid fa-rotate-right"></i></span>
                                                    </button>
                                                </form>                                           
                                                <!-- Delete -->
                                                <form action="{{ route('archive.destroy', $archive->id) }}" method="POST">
                                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                @csrf
                                                <!-- Dirtective to Override the http method -->
                                                @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Delete PERMANENTLY Entry with (ID: {{  $archive->id }})?')"                                                        
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
            <div class="flex flex-row justify-end items-center py-4 px-4 bg-red-400 sm:rounded-b-lg">
                <a href="{{ route('dashboard') }}">
                    <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                        title="Go Back"></i>
                </a>
            </div>

        </div>

    </div>

</div>




