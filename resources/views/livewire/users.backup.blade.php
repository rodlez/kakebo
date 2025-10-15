<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
<!-- {{ var_dump($users) }} -->
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/users" class="font-bold text-black border-b-2 border-b-yellow-600">Users</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <div>

            <!-- Header -->
            <div class="flex flex-row justify-between items-center py-4 bg-yellow-400">
                <div>
                    <span class="text-lg text-white px-4">Users <span
                            class="text-sm">({{ $search != '' ? $found : $total }})</span></span>
                </div>
                <div class="px-4">
                    <a href="#"
                        class="text-white text-sm sm:text-md rounded-lg py-2 px-4 bg-black hover:bg-gray-600 transition duration-1000 ease-in-out"
                        title="Create New user">New</a>
                </div>
            </div>
            <!-- FILTERS-->
            <div
                class="flex flex-row justify-between items-center py-2 px-4 mt-2 border-green-600 border-b-2 w-full">
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
                        <select wire:model.live="isAdmin" class="rounded-lg w-full md:w-80">
                            <option value="2">All</option>
                            <option value="0">Users</option>
                            <option value="1">Admins</option>
                        </select>
                        @if ($isAdmin != 2)
                            <a wire:click.prevent="clearFilterIsAdmin" title="Reset Filter" class="cursor-pointer">
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
                <!-- End Filters -->
            </div>
            @endif
            <!-- Search Type-->
            <div class="flex flex-row sm:flex-col justify-start items-start px-2 sm:px-4 py-2 gap-2">
                <div class="border-blue-600 border-b-2 w-full sm:w-full">
                    <span class="px-2 text-lg text-zinc-800">Search</span>
                </div>
                <div>
                    <label class="px-2"><input type="radio" wire:model.live="searchType" value="name"><span class="pl-2">Name</span></label>
                    <label class="px-2"><input type="radio" wire:model.live="searchType" value="email"><span class="pl-2">Email</span></label>                    
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-start px-2 sm:px-2 py-0 gap-2">                
                <!-- Search Word -->
                <div class="relative w-full">
                    <div class="absolute top-0.5 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input wire:model.live="search" type="search"
                        class="w-full rounded-lg pl-10 font-sm placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-orange-400 border-2 border-zinc-200"
                        placeholder="Search by {{ $searchType }}">
                    @if ($search != '')
                    <div class="absolute top-0.5 bottom-0 right-2 text-slate-700">
                        <a wire:click.prevent="clearSearch" title="Clear Search" class="cursor-pointer">
                            <span class="text-red-600 hover:text-red-400 px-2">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </span>
                        </a>
                    </div>
                    @endif
                </div>               
                
                <!-- Pagination -->
                <div class="relative w-32">
                    <div class="absolute top-0 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <select wire:model.live="perPage"
                        class="w-full rounded-lg text-end focus:outline-none focus:ring-0 focus:border-orange-400 border-2 border-zinc-200 ">
                        <option value="3">3</option>
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
            <!-- Table -->
            <div class="px-0 sm:px-4 pb-0 ">
                <div class="overflow-x-auto">

                    @if ($users->count())
                        <table class="min-w-full ">
                            <thead>
                                <tr class="text-black text-left text-sm font-normal uppercase">
                                    <th></th>
                                    <th wire:click="sorting('users.id')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-yellow-600 {{ $column == 'id' ? 'text-yellow-600' : '' }}">
                                        id {!! $sortLink !!}</th>
                                    <th wire:click="sorting('users.name')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-yellow-600 {{ $column == 'name' ? 'text-yellow-600' : '' }}">
                                        name {!! $sortLink !!}</th>
                                    <th wire:click="sorting('users.email')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-yellow-600 {{ $column == 'email' ? 'text-yellow-600' : '' }}">
                                        email {!! $sortLink !!}</th>
                                    <th wire:click="sorting('users.name')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-yellow-600 {{ $column == 'is_admin' ? 'text-yellow-600' : '' }}">
                                        admin {!! $sortLink !!}</th> 
                                    <th scope="col" class="p-2 text-center capitalize">Entries</th>                                   
                                    <th wire:click="sorting('users.created_at')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-yellow-600 {{ $column == 'created_at' ? 'text-yellow-600' : '' }}">
                                        created {!! $sortLink !!}</th>
                                    <th wire:click="sorting('users.updated_at')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-yellow-600 {{ $column == 'updated_at' ? 'text-yellow-600' : '' }}">
                                        updated {!! $sortLink !!}</th>
                                    <th scope="col" class="p-2 text-center capitalize">actions</th>
                                </tr>
                            </thead>
                            <!-- TABLE BODY -->
                            <tbody>

                                @foreach ($users as $user)
                                    <tr
                                        class="text-black text-sm leading-6 even:bg-zinc-200 odd:bg-gray-300 transition-all duration-1000 hover:bg-yellow-400">
                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value="{{ intval($user->id) }}" 
                                                id="{{ $user->id }}"
                                                {{ in_array($user->id, $selections) ? 'checked' : '' }}
                                                >
                                        </td>
                                        <td class="p-2">{{ $user->id }}</td>
                                        <td class="p-2">{{ $user->name }}</td>
                                        <td class="p-2">{{ $user->email }}</td>
                                        <td class="p-2">{{ ($user->is_admin == 1) ? 'Yes' : 'No' }}</td>
                                        <td class="p-2">{{ $user->entries->count() }}</td>
                                        <td class="p-2">{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                                        <td class="p-2">{{ date('d-m-Y', strtotime($user->updated_at)) }}</td>
                                        
                                        <td class="p-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <!-- Show -->
                                                <a href="#" title="Show">
                                                    <i
                                                        class="fa-solid fa-circle-info text-yellow-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Edit -->
                                                <a href="#" title="Edit">
                                                    
                                                    <i
                                                        class="fa-solid fa-pen-to-square text-green-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form action="#" method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Are you sure you want to delete the user: {{ $user->name }}?')"
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
                    @else
                        <div
                            class="flex flex-row justify-between items-center bg-black text-white rounded-lg p-4 mx-2 sm:mx-0">
                            <span>No users found in the system.</span>
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
                {{ $users->links() }}
            </div>
            <!-- Footer -->
            <div class="flex flex-row justify-end items-center py-4 px-4 bg-yellow-400 sm:rounded-b-lg">
                <a href="{{ route('dashboard') }}">
                    <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                        title="Go Back"></i>
                </a>
            </div>

        </div>

    </div>

</div>



