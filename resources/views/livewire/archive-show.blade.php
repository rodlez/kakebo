<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/archive" class="hover:text-red-600">Entries</a> /
        <a href="/archive/show/{{ $archive->id }}" class="font-bold text-black border-b-2 border-b-red-600">Info</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-orange-600">
            <span class="text-lg text-white px-4">Entry Info (Archived)</span>
        </div>

        <!-- INFO -->
        <div class="mx-auto w-11/12 sm:w-4/5 mt-4 my-10 bg-gray-100 rounded-md shadow-sm">

            <div class="flex flex-row justify-between items-center py-4 sm:pb-8 sm:pt-0 sm:rounded-t-lg bg-black">
                <span class="text-xl text-white font-bold capitalize sm:mt-8 mx-4">Information</span>
                <div class="flex flex-row justify-end items-end gap-4 w-fit sm:mt-8 mx-2">                    
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
                                    class="text-green-600 hover:text-black transition-all duration-500">
                                    <i
                                        class="fa-lg fa-solid fa-rotate-right text-white hover:text-green-400 transition duration-1000 ease-in-out"></i></span>
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
                                    class="text-green-600 hover:text-black transition-all duration-500">
                                    <i
                                        class="fa-lg fa-solid fa-trash text-white hover:text-red-600 transition duration-1000 ease-in-out"></i></span>
                            </button>
                    </form>                    
                </div>
            </div>

            <!-- Id -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 sm:border-t border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-fingerprint w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Id</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $archive->id }}</span>
            </div>
            <!-- User -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-circle-user w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">User</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $archive->user->name }} - {{ $archive->user->email }}</span>
            </div>            
            <!-- Date -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-calendar-days w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Date</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $archive->date }}</span>
            </div>
            <!-- Title -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <!-- Clipboard Title Button-->
                <div class="flex flex-row justify-start items-center gap-2">
                    <span x-data="{ show: false }" class="relative" data-tooltip="Copy Title">
                        <button class="btn" data-clipboard-target="#title" x-on:click="show = true"
                            x-on:mouseout="show = false" title="Copy Title">
                            <i
                                class="fa-solid fa-pen-to-square w-6 text-center text-black hover:text-blue-600 transition-all duration-500"></i>
                        </button>
                        <span x-show="show" class="absolute -top-8 -right-6">
                            <span class="bg-orange-600 text-white rounded-lg p-2 opacity-100">Copied!</span>
                        </span>
                    </span>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Title</span>
                </div>
                <div id="title" class="w-full px-8 sm:px-2">{{ $archive->title }}</div>
            </div>
            <!-- Type -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 sm:border-t border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-toggle-on w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Type</span>
                </div>
                <span
                    class="w-full px-8 sm:px-2 {{ $archive->type == 0 ? 'text-red-600' : 'text-orange-600' }}">{{ $archive->type == 0 ? 'Gasto' : 'Ingreso' }}</span>
            </div>
            <!-- Value -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-clock w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Value</span>
                </div>
                <span
                    class="w-full px-8 sm:px-2 {{ $archive->type == 0 ? 'text-red-600' : 'text-orange-600' }}">{{ $archive->value }} €</span>                
            </div>
            <!-- Frequency -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-route w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Frequency</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $archive->frequency }}</span>
            </div>
            <!-- Company -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-location-dot w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Company</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $archive->company }}</span>
            </div>
            <!-- Category -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-2 sm:gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-basketball w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Category</span>
                </div>
                <div class="w-full px-8 sm:px-2">
                    <span
                        class="bg-blue-600 text-white text-sm font-bold rounded-md p-2">{{ $archive->category->name }}</span>
                </div>
            </div>
            <!-- Tags -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-2 sm:gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-tags w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Tags</span>
                </div>
                <div class="flex flex-row flex-wrap w-full px-8 sm:px-2 gap-2">
                    @foreach ($archive->tags as $tag)
                        <span
                            class="bg-orange-600 text-white text-sm font-bold rounded-md p-2">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>                        
            <!-- Info -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center sm:items-start pb-2 gap-2">
                    <i class="fa-solid fa-circle-info py-1 w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Info</span>
                </div>
                @if (strip_tags($archive->info) != '')
                    <div class="flex relative w-full">
                        <!-- Quill Editor -->
                        <div id="quill_editor"
                            class="w-full p-2 text-md rounded-lg bg-gray-200 border border-gray-300 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500 ">
                            {!! $archive->info !!}
                        </div>
                        <!-- Clipboard Info Button-->
                        <span x-data="{ show: false }" class="bg-white p-1 rounded-md absolute top-1 right-2"
                            data-tooltip="Copy Info">
                            <button class="btn" data-clipboard-target="#quill_editor" x-on:click="show = true"
                                x-on:mouseout="show = false">
                                <i class="fa-regular fa-clipboard"></i>
                            </button>
                            <span x-show="show" class="absolute top-1 right-6">
                                <span class="bg-orange-600 text-white rounded-lg p-1 opacity-100">Copied!</span>
                            </span>
                        </span>
                    </div>
                @else
                    <div class="w-full px-8 sm:px-2">-</div>
                @endif
            </div>

            <!-- Files -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1">
                <div class="flex flex-row justify-start items-center sm:items-start pb-2 gap-2">
                    <i class="fa-solid fa-file py-1 w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Files
                        ({{ $archive->files->count() }})</span>
                </div>
                <!-- file Table -->
                <div class="w-full overflow-x-auto">
                    @if ($archive->files->count() !== 0)
                        <table class="table-auto w-full border text-sm">
                            <thead class="text-sm text-center text-white bg-black">
                                <th></th>
                                <th class="p-2 max-lg:hidden">Filename</th>
                                <th class="p-2 max-sm:hidden">Created</th>
                                <th class="p-2 max-sm:hidden">Size <span class="text-xs">(KB)</span></th>
                                <th class="p-2">Format</th>
                                <th></th>
                            </thead>

                            @foreach ($archive->files as $file)
                                <tr class="bg-white border-b text-center">
                                    <td class="p-2">
                                        @include('partials.mediatypes-file', [
                                            'file' => $file,
                                            'iconSize' => 'fa-lg',
                                            'imagesBig' => false,
                                        ])
                                    </td>
                                    <td class="p-2 max-lg:hidden">
                                        {{ $file->original_filename }}
                                    </td>
                                    <td class="p-2 max-sm:hidden">{{ $file->created_at->format('d-m-Y') }}
                                    </td>
                                    <td class="p-2 max-sm:hidden">{{ round($file->size / 1000) }} </td>
                                    <td class="p-2 ">{{ basename($file->media_type) }}</td>                                   

                                </tr>
                            @endforeach

                        </table>
                    @endif                    

                </div>
            </div>

            <div class="bg-black py-4 sm:rounded-b-md">

            </div>


        </div>

    </div>

    <!-- To the Top Button -->
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa-solid fa-angle-up"></i></button>

    <!-- Footer -->
    <div class="py-4 flex flex-row justify-end items-center px-4 bg-orange-600 sm:rounded-b-lg">
        <a href="{{ route('entries.index') }}">
            <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                title="Go Back"></i>
        </a>
    </div>

</div>

</div>

<script>
    new ClipboardJS('.btn');
</script>
