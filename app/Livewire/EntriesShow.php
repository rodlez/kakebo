<?php

namespace App\Livewire;

use App\Models\Entry;
use Livewire\Component;

class EntriesShow extends Component
{
    public Entry $entry;

    public function mount(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function render()
    {
        return view('livewire.entries-show', [
            'entry' => $this->entry
        ]);
    }    
   
}
