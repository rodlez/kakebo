<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {  
        // resticted access - only user who owns the Sport has access
         if ($entry->user_id !== Auth::id()) {
            abort(403);
        }   
         try {            
            $entry->delete();
            return to_route('entries.index')->with('message', 'Entry (' . $entry->name . ') deleted.');
        } catch (Exception $e) {
            return to_route('entries.index')->with('message', 'Error (' . $e->getCode() . ') Entry: ' . $entry->name . ' can not be deleted.');
        }              
    }

    
}
