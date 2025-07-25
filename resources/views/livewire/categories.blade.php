<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
<!-- {{ var_dump($categories) }} -->
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/categories" class="font-bold text-black border-b-2 border-b-blue-600">Categories</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <div>

            <!-- Header -->
            <div class="flex flex-row justify-between items-center py-4 bg-blue-400">
                <div>
                    <span class="text-lg text-white px-4">Categories <span
                            class="text-sm">({{ $search != '' ? $found : $total }})</span></span>
                </div>
                <div class="px-4">
                    <a href="{{ route('categories.create') }}"
                        class="text-white text-sm sm:text-md rounded-lg py-2 px-4 bg-black hover:bg-gray-600 transition duration-1000 ease-in-out"
                        title="Create New Category">New</a>
                </div>
            </div>
            <!-- Search -->
            <div class="flex flex-col sm:flex-row justify-between items-start px-2 sm:px-4 py-4 gap-4">
                <!-- Search -->
                <div class="relative w-full">
                    <div class="absolute top-2.5 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input wire:model.live="search" type="search"
                        class="w-full rounded-lg pl-10 font-sm placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-blue-400 border-2 border-zinc-200"
                        placeholder="Search by name">
                </div>
                <!-- Pagination -->
                <div class="relative w-32">
                    <div class="absolute top-2.5 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <select wire:model.live="perPage"
                        class="w-full rounded-lg text-end focus:outline-none focus:ring-0 focus:border-blue-400 border-2 border-zinc-200 ">
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
                            <span>X<i class="fa-solid fa-rotate-right text-green-600 hover:text-green-500"></i></span>
                        </a>
                        <a wire:click.prevent="bulkDelete" wire:confirm="Are you sure you want to delete this items?"
                            class="cursor-pointer text-red-600 hover:text-red-500" title="Delete">
                            <span>D<i class="fa-sm fa-solid fa-trash"></i></span>
                            <span>({{ count($selections) }})</span>
                        </a>
                    </div>
                </div>
            @endif
            <!-- Table -->
            <div class="px-0 sm:px-4 pb-0 ">
                <div class="overflow-x-auto">

                    @if ($categories->count())
                        <table class="min-w-full ">
                            <thead>
                                <tr class="text-black text-left text-sm font-normal uppercase">
                                    <th></th>
                                    <th wire:click="sorting('categories.id')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-blue-600 {{ $column == 'id' ? 'text-blue-600' : '' }}">
                                        id {!! $sortLink !!}</th>
                                    <th wire:click="sorting('categories.name')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-blue-600 {{ $column == 'name' ? 'text-blue-600' : '' }}">
                                        name {!! $sortLink !!}</th>
                                    <th wire:click="sorting('categories.created_at')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-blue-600 {{ $column == 'created_at' ? 'text-blue-600' : '' }}">
                                        created {!! $sortLink !!}</th>
                                    <th wire:click="sorting('categories.updated_at')" scope="col"
                                        class="p-2 hover:cursor-pointer hover:text-blue-600 {{ $column == 'updated_at' ? 'text-blue-600' : '' }}">
                                        updated {!! $sortLink !!}</th>
                                    <th scope="col" class="p-2 text-center capitalize">actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($categories as $category)
                                    <tr
                                        class="text-black text-sm leading-6 even:bg-zinc-200 odd:bg-gray-300 transition-all duration-1000 hover:bg-blue-400">
                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ $category->id }}></td>
                                        <td class="p-2">{{ $category->id }}</td>
                                        <td class="p-2"> <a
                                                href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                                        </td>
                                        <td class="p-2">{{ date('d-m-Y', strtotime($category->created_at)) }}</td>
                                        <td class="p-2">{{ date('d-m-Y', strtotime($category->updated_at)) }}</td>
                                        
                                        <td class="p-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <!-- Show -->
                                                <a href="{{ route('categories.show', $category) }}" title="Show">
                                                    ver<i
                                                        class="fa-solid fa-circle-info text-blue-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Edit -->
                                                <a href="{{ route('categories.edit', $category) }}" title="Edit">
                                                    edit
                                                    <i
                                                        class="fa-solid fa-pen-to-square text-green-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Are you sure you want to delete the category: {{ $category->name }}?')"
                                                        title="Delete">
                                                        delete
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
                            <span>No categories found in the system.</span>
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
                {{ $categories->links() }}
            </div>
            <!-- Footer -->
            <div class="flex flex-row justify-end items-center py-4 px-4 bg-blue-400 sm:rounded-b-lg">
                <a href="{{ route('dashboard') }}">
                    <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                        title="Go Back"></i>
                </a>
            </div>

        </div>

    </div>

</div>

