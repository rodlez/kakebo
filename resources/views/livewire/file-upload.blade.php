<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/entries" class="hover:text-green-600">Entries</a> /
        <a href="/entries/show/{{$entry->id}}" class="hover:text-green-600">Info</a> /
        <a href="/entries/{{ $entry->id }}/file" class="font-bold text-black border-b-2 border-b-green-600">Upload
            File</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-green-600">
            <span class="text-lg text-white px-4">Upload File</span>
        </div>

        <!-- Entry Information -->
        <div class="flex flex-col mx-4 my-2 pt-4 pb-1 border-b-2 border-b-green-600 text-xl font-semibold">
            <h2>Entry <span class="text-sm"> (ID: {{ $entry->id }})</span></h2>
            <span class="text-gray-600 text-sm italic font-thin">{{ $entry->title }}</span>
        </div>

        <!-- Files Associated to the Entry -->
        <div class="mx-4 py-1 text-xs font-semibold">Files in this Entry ({{ $entry->files->count() }} of 5)</div>

        @if ($entry->files->count() > 0)
            <div
                class="mx-4 py-2 flex flex-row md:flex-row justify-start items-center w-fit px-4 border-2 rounded-lg gap-4 bg-gray-200">
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
                            <button class="absolute top-0 right-0"
                                onclick="return confirm('Are you sure you want to delete the file: {{ $file->original_filename }}?')"
                                title="Delete file">
                                
                                <span class="text-red-600 hover:text-red-700 transition-all duration-500"><i
                                        class="fa-solid fa-circle-xmark fa-md"></i></span>
                            </button>
                        </form> 
                    </div>
                @endforeach
            </div>
        @endif

        @if ($entry->files->count() >= 5)
            <div class="mx-4 py-4 text-lg text-red-400 font-semibold">You have reached the limit of files for this
                entry. Delete some to upload new ones.</div>
            <div class="mx-4 py-8">
                <!-- Back -->
                <a href="{{ route('entries.show', $entry) }}"
                    class="w-full md:w-1/3 bg-black hover:bg-slate-600 text-white text-center font-bold py-2 px-4 rounded-md">
                    Back
                </a>
            </div>
        @else
            <div class="mx-4 py-4">
                <form wire:submit.prevent="save">
                    <label class="text-lg text-gray-500 font-semibold mb-2 block">Upload files</label>
                    <input wire:model.live="files" multiple type="file"
                        class="w-full text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-black file:hover:bg-slate-600 file:text-white rounded ease-linear transition-all duration-500" />
                    <p class="text-xs text-black font-semibold mt-2">Allowed formats: PDF, JPG, JPEG, PNG, TXT, DOC,
                        ODT.</p>
                        <p class="text-xs text-black font-semibold mt-0">Max Size File: 1Gb</p>

                    @if (count($files) + $entry->files->count() > 5)
                        <div class="my-4">
                            <span class="text-red-600 font-semibold">You have reached the limit of files
                                ({{ count($files) + $entry->files->count() }}) for this entry. Delete some to
                                upload
                                new ones.</span>
                        </div>
                    @else
                        <button
                            class="bg-black hover:bg-slate-600 text-white font-bold uppercase text-sm px-6 py-3 my-4 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-500"
                            type="submit">
                            <i class="fa-solid fa-file-arrow-up fa-lg px-1"></i> Upload
                        </button>
                    @endif

                    @error('files')
                        <div class="mt-4 mb-0 py-2 text-sm text-red-600 font-semibold">{{ $message }}</div>
                    @enderror
                    @error('files.*')
                        @if ($message == 'At least one file is not one of the allowed formats: PDF, JPG, JPEG or PNG')
                            <div class="mt-4 mb-0 py-2 text-sm text-red-600 font-semibold"><i
                                    class="fa-solid fa-triangle-exclamation fa-2xl pr-2"></i> {{ $message }}</div>
                        @else
                            <div class="mt-4 mb-0 py-2 text-sm text-red-600 font-semibold">{{ $message }}</div>
                        @endif
                    @enderror
                </form>
            </div>

            <div class="mx-4 mb-12">
                @if (count($files) !== 0)
                    <div class="py-0"><span class="text-md px-2">Files selected to upload
                            ({{ count($files) }})</span></div>

                    <table class="table-auto w-full">
                        <thead class="text-sm text-center text-white bg-black h-10">
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
                @endif
            </div>

        @endif

        <!-- Footer -->
        <div class="flex flex-row justify-end items-center py-4 px-4 bg-green-600 sm:rounded-b-lg">
            <a href="{{ route('entries.show', $entry) }}">
                <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                    title="Go Back"></i>
            </a>
        </div>

    </div>

</div>

