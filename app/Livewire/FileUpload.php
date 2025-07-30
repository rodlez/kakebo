<?php

namespace App\Livewire;

use App\Models\Entry;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
     use WithFileUploads;
    
    public Entry $entry;

    public $files = [];

    // Dependency Injection to use the Service
    protected FileService $fileService;

    protected $rules = [
        'files' => 'array|min:1|max:5',
        //'files.*' => 'required|mimes:pdf,jpeg,png,jpg|max:2048',
        'files.*' => 'required|file|mimetypes:text/plain,application/pdf,image/jpeg,image/png,application/vnd.oasis.opendocument.text,application/vnd.openxmlformats-officedocument.wordprocessingml.document,video/mp4|max:1024000',
    ];

    protected $messages = [
        'files.min' => 'Select at least 1 file to upload (max 5 files)',
        'files.max' => 'Limited to 5 files to upload',
        'files.*.required' => 'Select at least one file to upload',
        //'files.*.mimes' => 'At least one file is not one of the allowed formats: PDF, JPG, JPEG or PNG',
        'files.*.mimetypes' => 'At least one file do not belong to the allowed formats: PDF, JPG, JPEG, PNG, TXT, DOC, ODT'
    ];

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        FileService $fileService,
    ) {
        $this->fileService = $fileService;
    }

    public function mount(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function deleteFile($position)
    {
        array_splice($this->files, $position, 1);
    }

    public function save()
    {       
        $this->validate();

        foreach ($this->files as $file) {
            // use entryiId as a folder name for the files uploaded for this entry
            $storagePath = 'entryfiles/' . $this->entry->id;
            $data = $this->fileService->uploadFile($file, $this->entry->id, 'entry_id', 'public', $storagePath);
            // if there is an error, create method will throw an exception
            File::create($data);            
        }
        
        return to_route('entries.show', $this->entry)->with('message', 'File(s) for (' . $this->entry->title . ') successfully uploaded.');
    }

    public function render()
    {
        // resticted access - only user who owns the entry has access
        if ($this->entry->user_id !== Auth::id()) {
            abort(403);
        }  

        return view('livewire.file-upload', [
            'entry' => $this->entry
        ]);
    }

}
