<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/archive" class="text-black hover:text-red-600">Archive</a> /
        <a href="/archive/show/{{$archive->id}}" class="font-bold text-black border-b-2 border-b-red-600">Info</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-red-400">
            <div>
                <span class="text-lg text-white px-4">Entry Info</span>
            </div>
        </div>
        <!-- Entry Data -->
        <div class="mx-auto w-11/12 py-4 px-2">
            <div><span class="font-semibold px-2">User</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">
                <input type="text" id="user" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ $archive->user->name }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Title</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">
                <input type="text" id="title" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ $archive->title }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Type</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="type" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ $archive->type ? 'ingreso' : 'gasto' }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Category</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="category" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ $archive->category->name }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Tags</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                @foreach ($archive->tags as $tag) 
                    <h2>{{ $tag->name }}</h2>
                @endforeach                                 
            </div>
            <div><span class="font-semibold px-2">Value</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="value" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ $archive->value }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Company</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="company" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ $archive->company }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Frequency</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="frequency" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ $archive->frequency }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Info</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="info" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ $archive->info }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Date</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="date" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ date('d-m-Y', strtotime($archive->date)) }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Created at</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="created_at" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ date('d-m-Y', strtotime($archive->created_at)) }}" disabled>                
            </div>
            <div><span class="font-semibold px-2">Updated at</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">                
                <input type="text" id="updated_at" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" value="{{ date('d-m-Y', strtotime($archive->updated_at)) }}" disabled>                
            </div>
        </div>        

        <!-- Footer -->
        <div class="flex flex-row justify-end items-center py-4 px-4 bg-red-400 sm:rounded-b-lg">
            <a href="{{ route('archive.index') }}">
                <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out" title="Go Back"></i>
            </a>
        </div>

    </div>

</div>
