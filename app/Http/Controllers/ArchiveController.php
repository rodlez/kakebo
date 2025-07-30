<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    public function __construct(private FileService $fileService) {        
    }

    /**
     * Restore the entry from Archive to Entries, Soft Delete DB Column deleted_at = NULL.
     */
    public function restore(int $entry)
    {              
        $data = Entry::onlyTrashed()->get();
        $restoreEntry = $data->where('id', '=', $entry)->first();

        if ($restoreEntry->user_id !== Auth::id()) {           
            abort(403);
        }   
         try {            
            $restoreEntry->restore();
            return to_route('archive.index')->with('message', 'Entry (' . $restoreEntry->name . ') restored.');
        } catch (Exception $e) {
            return to_route('archive.index')->with('message', 'Error (' . $e->getCode() . ') Entry: ' . $restoreEntry->name . ' can not be restored.');
        }         
                      
    }

    /**
     * Delete Permanently the Entry and delete his associated files in the storage
     */
     public function destroy(int $entryID)
    {   
        $entry = Entry::onlyTrashed()->find($entryID);        
        
        try {
            $files = $entry->files;
            // forceDelete method to permanently remove a soft deleted model from the database table
            $result = $entry->forceDelete();

            // If the Entry has been deleted, check if there is associated files and delete them.
            if ($result) {
                if ($files->isNotEmpty()) {
                    $this->fileService->deleteFiles($files);
                }
                
                return to_route('archive.index')->with('message', 'Entry (' . $entry->title . ') successfully deleted PERMANENTLY.');               
            } else {
                return to_route('archive.index')->with('message', 'Error - Files from Entry (' . $entry->title . ') can not be deleted.');
            }
        } catch (Exception $e) {            
            return to_route('archive.index')->with('message', 'Error(' . $e->getCode() . ') - Entry (' . $entry->title . ') can not be deleted.');
        }
           
                      
    }
   
}
