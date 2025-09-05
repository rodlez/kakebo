<?php

namespace App\Livewire;

use App\Livewire\Texteditor\Quill;
use App\Models\Balance;
use Illuminate\Http\Request;
use Livewire\Component;
use Exception;

class BalancesEdit extends Component
{
    public $name;
    public $source;
    public $total;
    public $date;
    public $info;
    
    protected $rules = [       
        'name'              => 'required|min:3',
        'source'            => 'required',
        'total'             => 'required|numeric|min:0',        
        'date'              => 'required|after:01/01/2015',
        'info'              => 'nullable|min:3',
    ];

    protected $messages = [
        'source.required' => 'Select one source.',

    ];

    public $listeners = [
        Quill::EVENT_VALUE_UPDATED
    ];
    
    public function quill_value_updated($value){

       // Remove more than 2 consecutive whitespaces
       if ( preg_match( '/(\s){2,}/s', $value ) === 1 ) {
           $value = preg_replace( '/(\s){2,}/s', '', $value );           
       }
       
       // Because Quill Editor includes <p><br></p> in case you type and then leave the input blank
       if($value == "<p><br></p>" || $value == "<h1><br></h1>" || $value == "<h2><br></h2>" || $value == "<h3><br></h3>" || $value == "<p></p>" || $value == "<p> </p>") { 
           $value = null;
       }
       
       $this->info = $value;

    }

    public Balance $balance;

    public function mount(Balance $balance)
    {
        $this->balance = $balance;
        // If the user is not authorized inmediatly abort
        //$this->entryService->authorization($this->entry);

        $this->name = $this->balance->name;
        $this->source = $this->balance->source;
        $this->total = $this->balance->total;
        $this->date = $this->balance->date;
        $this->info = $this->balance->info;        
    }

    public function save(Request $request)
    {
        $validated = $this->validate();
        $validated['user_id'] = $request->user()->id;

        // test error
        //$validated['name'] = null;
        //dd($validated);

        try {
            $this->balance->update($validated);
            return to_route('balances.show', $this->balance)->with('message', 'Account succesfully updated');
        } catch (Exception $e) {
            return to_route('balances.show', $this->balance)->with('error', 'Error(' . $e->getCode() . ') Account updated failed');            
        }
    }

    public function render()
    {
       // TODO: get frequencies from the enum in the DB or a Constant in config
        $sources    = ['cash','card','stocks'];

        return view('livewire.balances-edit', [
            'sources'   => $sources,
        ]);
    }
}
