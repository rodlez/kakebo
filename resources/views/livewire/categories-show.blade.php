<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/categories" class="text-black hover:text-blue-600">Categories</a> /
        <a href="/categories/{{$category->id}}" class="font-bold text-black border-b-2 border-b-blue-600">Info</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-blue-400">
            <div>
                <span class="text-lg text-white px-4">Category Info</span>
            </div>
        </div>
        <!-- Info -->
        <div class="mx-auto w-11/12 py-4 px-2">
            <div><span class="font-semibold px-2">Name</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">
                <!-- Name -->
                <input type="text" id="name" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $category->name }}" disabled>
                <!-- Edit -->
                <a href="{{ route('categories.edit', $category) }}">
                    edit
                    <i class="fa-solid fa-pen-to-square text-green-600 hover:text-black transition duration-1000 ease-in-out" title="Edit"></i>
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
        </div>

        <!-- Footer -->
        <div class="flex flex-row justify-end items-center py-4 px-4 bg-blue-400 sm:rounded-b-lg">
            <a href="{{ route('categories.index') }}">
                <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out" title="Go Back"></i>
            </a>
        </div>

    </div>

</div>

