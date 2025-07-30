<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Http\Request;
use Livewire\Component;

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
        'selectedTags'      => 'required',        
    ];

    protected $messages = [
        'category_id.required' => 'Select one category.',
        'selectedTags.required' => 'At least 1 tag must be selected.',
        'frequency.required' => 'Select one frequency.',

    ];

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->type = false;
        $this->value = 0;
        $this->category_id = Category::orderBy('name', 'asc')->pluck('id')->first();      
        //$this->frequency = Entry::orderBy('name', 'asc')->pluck('frequency')->first();      

    }

    public function save(Request $request)
    {
        $validated = $this->validate();
        //$validated['distance'] != "" ?: $validated['distance'] = 0;
        $validated['user_id'] = $request->user()->id;

        //dd($validated);

        $entry = Entry::create($validated);
        $entry->tags()->sync($validated['selectedTags']);

        return to_route('entries.index', $entry)->with('message', 'Sport (' . $entry->title . ') created.');
    }


    public function render()
    {
        // Using Eloquent Collection Methods
        $categories     = Category::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);    
        $tags           = Tag::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        //$frequencies    = Entry::all()->pluck('frequency');
        // TODO: get frequencies from the enum in the DB or a Constant in config
        $frequencies    = ['puntual','semanal','quincenal','mensual','bimensual','trimestral','semestral','anual'];

        return view('livewire.entries-create', [
            'categories'        => $categories,
            'tags'              => $tags,
            'frequencies'       => $frequencies,
        ]);
    }
}
