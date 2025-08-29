<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-row justify-between bg-green-600 text-white font-bold rounded-sm px-2 py-1 my-1">
            <span>{{ session('message') }}</span>
            <a href="/entries/{{ $entry->id }}/file"><i class="fa-solid fa-xmark"></i></a>
        </div>
    @endif

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 p-2 text-sm text-slate-600">
        <a href="/entries" class="hover:text-black">Entries</a> /
        <a href="/entries/show/{{$entry->id}}" class="hover:text-amber-600">Info</a> /
        <a href="/entries/{{ $entry->id }}/file" class="font-bold text-black border-b-2 border-b-violet-600">Upload</a>
    </div>

    <div class="bg-zinc-300 overflow-hidden shadow-sm sm:rounded-sm">
        
        <!-- Header -->
        <div class="flex flex-row p-2 bg-black">
            <span class="text-lg text-white border-b-2 border-b-violet-600">Upload File</span>
        </div>
       

        <div class="flex flex-col p-2">

            <!-- Entry Information -->
            <div class="flex flex-col border-b-2 border-b-violet-600 pb-1">
                <span class="font-bold text-violet-600">Entry <span class="text-sm"> (Id: {{ $entry->id }})</span></span>
                <span class="text-gray-600 text-sm">{{ $entry->title }}</span>
            </div>

            
            <!-- Files Associated to the Entry -->
            @if ($entry->files->count() > 0)
            
                <div class="flex flex-row">
                    <span class="text-xs font-bold py-1">Files stored in this entry ({{ $entry->files->count() }} of 5)</span>
                </div>
                
                <div class="flex flex-wrap md:flex-row justify-between items-center w-fit rounded-sm p-2 border-2 border-violet-600 gap-2 bg-white">
                    @foreach ($entry->files as $file)
                        <div class="relative py-2">

                            @include('partials.mediatypes-file', [
                                'file' => $file,
                                'iconSize' => 'fa-3x',
                                'imagesBig' => true,
                            ])

                            <!-- Delete file -->
                            <form action="{{ route('files.destroy', [$entry, $file]) }}" method="POST">
                                
                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                @csrf
                                <!-- Dirtective to Override the http method -->
                                @method('DELETE')
                                <button class="absolute top-0 right-1"
                                    onclick="return confirm('Are you sure you want to delete the file: {{ $file->original_filename }}?')"
                                    title="Delete file">
                                    
                                    <span class="text-red-600 hover:text-red-700 transition-all duration-500"><i
                                            class="fa-solid fa-circle-xmark"></i></span>
                                </button>
                            </form> 
                        </div>
                    @endforeach
                </div>
            @endif


            <div class="flex flex-col py-4">

                <form wire:submit.prevent="save">

                    <div class="flex flex-row">
                        <span class="text-lg text-violet-600 font-bold">Upload files</span>
                    </div>

                    <div class="flex flex-row">
                            <input wire:model.live="files" multiple type="file"
                        class="w-full md:w-1/2 text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:p-4 file:mr-4 file:bg-black file:hover:bg-slate-600 file:text-white rounded ease-linear transition-all duration-500" />
                    </div>

                    <div class="flex flex-col text-sm p-2">
                            <span class="text-md text-violet-600 font-bold">Allowed formats</span>
                            <span class="font-semibold">PDF, JPG, JPEG, PNG, TXT, DOC, ODT.</span>
                            <span class="text-xs text-black font-semibold pt-1">Max Size File: 1 Gb</span>    
                    </div>

                    @if (count($files) + $entry->files->count() > 5)
                        <div class="flex flex-row bg-red-600 text-sm text-white font-bold rounded-sm p-2">
                            <span>The limit of files for an entry are 5, you have already ({{ count($files) + $entry->files->count() }}) delete at least ({{ (count($files) + $entry->files->count()) - 5 }}) to be able to upload.</span>
                        </div>
                    @else
                        <button
                            class="bg-black hover:bg-slate-600 text-white font-bold uppercase text-sm px-6 py-3 my-4 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-500"
                            type="submit">
                            <i class="fa-solid fa-file-arrow-up fa-lg px-1"></i> Upload
                        </button>
                    @endif

                    @error('files')
                        <div class="flex flex-row bg-red-600 text-sm text-white font-bold rounded-sm p-2">{{ $message }}</div>
                    @enderror
                    @error('files.*')
                        @if ($message == 'At least one file do not belong to the allowed formats: PDF, JPG, JPEG, PNG, TXT, DOC, ODT')
                            <div class="flex flex-row justify-start items-center bg-red-600 text-sm text-white font-bold rounded-sm p-2 gap-2"><i
                                    class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</div>
                        @else
                            <div class="flex flex-row bg-red-600 text-sm text-white font-bold rounded-sm p-2">{{ $message }}</div>
                        @endif
                    @enderror

                </form>
            </div>                    

            <div class="flex flex-col">
                    @if (count($files) !== 0)
                        <div class="flex flex-row">
                            <span class="text-lg text-violet-600">Files selected to upload
                                ({{ count($files) }})</span>
                        </div>
                        <div class="overflow-x-auto">        
                            <table class="min-w-full">
                                <thead class="text-sm text-center text-white bg-violet-600 h-10">
                                    <th class="rounded-tl-lg"></th>
                                    <th>Filename</th>
                                    <th class="max-md:hidden">Size (KB)</th>
                                    <th class="max-md:hidden">Format</th>
                                    <th class="rounded-tr-lg"></th>
                                </thead>

                                <tbody>

                                    @php($position = 0)
                                    @foreach ($files as $file)
                                        <tr class="text-center even:bg-zinc-200 odd:bg-white">

                                            <td class="py-2">
                                                @include('partials.mediatypes-fileupload', [
                                                    'file' => $file,
                                                    'iconSize' => 'fa-2x',
                                                ])
                                            </td>

                                            <td class="py-2">{{ $file->getClientOriginalName() }}</td>
                                            <td class="py-2 max-w-10 max-md:hidden">{{ round($file->getSize() / 1000) }}</td>
                                            {{-- <td class="py-2 max-md:hidden">{{ $file->getMimeType() }}</td> --}}
                                            <td class="py-2 max-w-12 max-md:hidden">{{ $file->getClientOriginalExtension() }}
                                            </td>
                                            <td class="py-2 px-2">
                                                <a wire:click="deleteFile({{ $position }})" class="cursor-pointer"
                                                    title="Delete File">
                                                    <span
                                                        class="text-red-600 hover:text-black ease-linear transition-all duration-500"><i
                                                            class="fa-solid fa-trash"></i></span>
                                                </a>
                                            </td>
                                        </tr>

                                        @php($position++)
                                    @endforeach
                                </tbody>
                                <tfoot class="h-6">
                                    <tr class="bg-black ">
                                        <td class="rounded-b-lg" colspan="5"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
 

        </div>    

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-black rounded-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>

    </div>

</div>

