<?php

namespace App\Livewire;

use App\Models\Entry;
use App\Services\EntryService;
use Livewire\Component;

class Stats extends Component
{
     public Entry $entry;

    // Dependency Injection to use the Service
    protected EntryService $entryService;

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        EntryService $entryService,
    ) {
        $this->entryService = $entryService;
    }

    public function mount(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function render()
    {

        return view('livewire.stats', [
            'todayBalance' => $this->entryService->getStatsTime('today'),
            'weekBalance' => $this->entryService->getStatsTime('week'),
            'monthBalance' => $this->entryService->getStatsTime('month'),
        ]);
    }
}
