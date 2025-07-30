<?php

namespace App\Services;

// Models

// Files
use Illuminate\Support\Facades\Storage;

// Collection
use Illuminate\Database\Eloquent\Collection;

class FileService
{

    /**
     * Upload a file and return an array with the info to make the insertion in the DB table 
     */

     public function uploadFile(mixed $file, int $elementId, string $columnId, string $disk, string $storagePath): array
     {         
        // Info to store in the DB
         $original_filename = $file->getClientOriginalName();
         $media_type = $file->getMimeType();
         $size = $file->getSize();                 
         // Storage in filesystem file config, specify the storagePath
         $path = Storage::disk($disk)->putFile($storagePath, $file);
         $storage_filename = basename($path);
 
         return [
              $columnId => $elementId,
             'original_filename' => $original_filename,
             'storage_filename' => $storage_filename,
             'path' => $path,
             'media_type' => $media_type,
             'size' => $size,
         ];
     }

     //TODO: check download method in storage
      /**
     * Download a file, disposition inline(browser) or attachment(download)
     */

    // public function downloadFile(mixed $file, string $disposition)
    // {
    //     // No need to specify the disposition to download the file.
    //     $dispositionHeader = [
    //         'Content-Disposition' => $disposition,
    //     ];

    //     if (Storage::disk('public')->exists($file->path)) {
    //         //return Storage::disk('public')->download($file->path, $file->original_filename, $dispositionHeader);
    //         return Storage::disk('public')->download($file->path, $file->original_filename);
    //     } else {
    //         return back()->with('message', 'Error: File ' . $file->original_filename . ' can not be downloaded.');
    //     }
    // }

    /**
     * Inset new Note and insert the tags in the intermediate table note_tag
     */
    public function deleteFiles(Collection $files)
    {
        foreach ($files as $file) {
            $this->deleteOneFile($file);
        }
    }

    /**
     * Inset new Note and insert the tags in the intermediate table note_tag
     */
    public function deleteOneFile(mixed $file)
    {
        if (Storage::disk('public')->exists($file->path)) {
            /*  echo $file->path;
             dd('borradito'); */
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }
    }

}