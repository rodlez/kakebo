<?php

namespace App\Livewire;

use App\Livewire\Texteditor\Quill;
use App\Models\Balance;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Http\Request;
use Livewire\Component;
use Exception;

class EntriesCreate extends Component
{
    public $type;
    public $title;
    public $date;
    public $company;
    public $value;
    public $frequency;
    public $info;
    public $category_id;
    public $balance_id;
    public $selectedTags = [];

    protected $rules = [
        'type'              => 'nullable',
        'title'             => 'required|min:3',
        'date'              => 'required|after:01/01/2015',
        'company'           => 'required|min:3',
        'value'             => 'required|numeric|min:0',                
        'info'              => 'nullable|min:3',
        'frequency'         => 'required',
        'category_id'       => 'required',
        'balance_id'        => 'required',
        'selectedTags'      => 'required',        
    ];

    protected $messages = [
        'category_id.required' => 'Select one category.',
        'balance_id.required'  => 'Select one balance.',
        'selectedTags.required' => 'At least 1 tag must be selected.',
        'frequency.required' => 'Select one frequency.',

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
        $this->type = 0;
        $this->value = 0;
        $this->frequency = 'puntual';
        $this->category_id = Category::orderBy('name', 'asc')->pluck('id')->first();      
        $this->balance_id = Balance::orderBy('name', 'asc')->pluck('id')->first();   
          
        // var_dump($this->balance_id);
        // dd($this->balance_id);

    }

    public function save(Request $request)
    {
        //dd($request);
        $validated = $this->validate();
        $validated['user_id'] = $request->user()->id;
        // TODO: CHECK WHY GET balance_id come as string and not as int like category_id
        //$validated['balance_id'] = intval($validated['balance_id']);
        //dd($validated);
        // $entry = Entry::create($validated);
        // $entry->tags()->sync($validated['selectedTags']);

        // return to_route('entries.index', $entry)->with('message', 'Sport (' . $entry->title . ') created.');

        // test error
        // $validated['user_id'] = null;

        try {
            $entry = Entry::create($validated);
            $entry->tags()->sync($validated['selectedTags']); 
            return to_route('entries.index', $entry)->with('message', 'Entry ID (' . $entry->id . ') created successfully');
        } catch (Exception $e) {
            return to_route('entries.index')->with('error', 'Error (' . $e->getCode() . ') failed when create a new entry');            
        }
    }


    public function render()
    {
        // Using Eloquent Collection Methods
        $categories     = Category::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);    
        $balances       = Balance::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);    
        $tags           = Tag::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        //$frequencies    = Entry::all()->pluck('frequency');
        // TODO: get frequencies from the enum in the DB or a Constant in config
        $frequencies    = ['puntual','semanal','quincenal','mensual','bimensual','trimestral','semestral','anual'];

        return view('livewire.entries-create', [
            'categories'        => $categories,
            'balances'          => $balances,
            'tags'              => $tags,
            'frequencies'       => $frequencies,
        ]);
    }
}
