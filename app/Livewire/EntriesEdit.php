<?php

namespace App\Livewire;

use App\Livewire\Texteditor\Quill;
use App\Models\Balance;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use App\Services\EntryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Exception;

class EntriesEdit extends Component
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
        'value'             => 'required|numeric|min:0|decimal:2',        
        'frequency'         => 'required',
        'info'              => 'nullable|min:3',
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
        // If the user is not authorized inmediatly abort
        $this->entryService->authorization($this->entry);

        $this->title = $this->entry->title;
        $this->type = $this->entry->type;
        $this->date = $this->entry->date;
        $this->category_id = $this->entry->category_id;
        $this->balance_id = $this->entry->balance_id;
        $this->company = $this->entry->company;
        $this->value = $this->entry->value;
        $this->frequency = $this->entry->frequency;
        $this->info = $this->entry->info;
        
        $this->selectedTags = $this->entry->tags->pluck('id');
        //$this->selectedTags = $this->sportService->getSportEntryTags($this->sport);       
       //dd($this->selectedTags);
    }

    public function save(Request $request)
    {
        $validated = $this->validate();
        $validated['user_id'] = $request->user()->id;

        //$validated['user_id'] = null;
        //dd($validated);

        try {
            $this->entry->update($validated);
            $this->entry->tags()->sync($validated['selectedTags']); 
            return to_route('entries.index', $this->entry)->with('message', 'Entry (' . $this->entry->title . ') updated.');
        } catch (Exception $e) {
            return to_route('entries.index', $this->entry)->with('error', 'Error (' . $e->getCode() . ') when try to update (' . $this->entry->title . ')');            
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

        return view('livewire.entries-edit', [
            'categories'        => $categories,
            'balances'          => $balances,
            'tags'              => $tags,
            'frequencies'       => $frequencies,
        ]);
    }
}
