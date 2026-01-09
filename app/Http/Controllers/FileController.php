<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileController extends Controller
{
    public function __construct(private FileService $fileService) {        
    }
    
    // public function download(Entry $sport, File $file)
    // {
    //     return $this->fileService->downloadFile($file, 'attachment');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry, File $file)
    {          
        $this->fileService->deleteOneFile($file);
        
        return back()->with('message', 'File ' . $file->original_filename . ' deleted.');
    }

    /**
     * TEST DOWNLOAD FILE
     */

    public function downloadFile(Entry $entry, File $file)
    {        

        //dd($file->path);
        if (Storage::disk('public')->exists($file->path)) {                             
            return Storage::disk('public')->download($file->path, $file->original_filename);            
        } else {
            return back()->with('message', 'Error: File ' . $file->original_filename . ' can not be downloaded.');
        }

        return back()->with('message', 'File ' . $file->original_filename . ' downloaded.');

    }

    /**
     * TEST DOWNLOAD ZIP
     */

    public function downloadZip(Entry $entry)
    {           

        $zip_name = '/entry_ID_' . $entry->id . '_files.zip';
        
        $file_path = $entry->files[0]->path;

        $folder_path = current(explode('/', $file_path)) . '/' . $entry->files[0]->entry_id;
        
        //dd(($folder_path));
        //dd(file_exists('storage/entryfiles/36/o3sq4WH8ArfD29PRKBC60Pq6B5i2qaOCAA3kgcwo.jpg'));
        $zip_file = 'storage/'. $folder_path . $zip_name;

        $zip = new ZipArchive;

        if ($zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {

            foreach ($entry->files as $file) {
                if (file_exists('storage/' . $file->path)) {
                    $zip->addFile('storage/' . $file->path, $file->original_filename);
                }
            }
            $zip->close();
            return response()->download($zip_file);            
        } else {
            return back()->with('message', 'Error: Files can not be downloaded.');
        }        

    }
   
}
