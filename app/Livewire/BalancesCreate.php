<?php

namespace App\Livewire;

use App\Livewire\Texteditor\Quill;
use App\Models\Balance;
use Illuminate\Http\Request;
use Livewire\Component;

class BalancesCreate extends Component
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

    /* Quill Editor - removing spaces  */
 
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

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->total = 0;
    }

    public function save(Request $request)
    {
        $validated = $this->validate();
        $validated['user_id'] = $request->user()->id;
        
        $balance = Balance::create($validated);

        return to_route('balances.index', $balance)->with('message', 'Balance (' . $balance->name . ') created.');
    }

    public function render()
    {
        // TODO: get frequencies from the enum in the DB or a Constant in config
        $sources    = ['cash','card','stocks'];

        return view('livewire.balances-create', [
            'sources'   => $sources,
        ]);
    }
}
