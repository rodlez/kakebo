<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Services\EntryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BalancesShow extends Component
{
    public Balance $balance;

    public function mount(Balance $balance)
    {
        $this->balance = $balance;
    }

    public function render()
    {
        // if(!Auth::user()->is_admin) {
        //     if ($entry->user_id !== Auth::user()->id) {
        //         abort(403);
        //     }
        // }                 

        return view('livewire.balances-show', [
            'balance' => $this->balance
        ]);
    }    
    
}
