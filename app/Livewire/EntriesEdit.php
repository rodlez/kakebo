<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Http\Request;
use Livewire\Component;

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

    public Entry $entry;

    public function mount(Entry $entry)
    {
        $this->entry = $entry;

        $this->title = $this->entry->title;
        $this->type = $this->entry->type;
        $this->date = $this->entry->date;
        $this->category_id = $this->entry->category_id;
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
        //$validated['distance'] != "" ?: $validated['distance'] = 0;
        $validated['user_id'] = $request->user()->id;

        //dd($validated);

        $this->entry->update($validated);
        $this->entry->tags()->sync($validated['selectedTags']);        

        return to_route('entries.index', $this->entry)->with('message', 'Entry (' . $this->entry->title . ') updated.');
    }

    public function render()
    {
        // Using Eloquent Collection Methods
        $categories     = Category::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);    
        $tags           = Tag::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        //$frequencies    = Entry::all()->pluck('frequency');
        // TODO: get frequencies from the enum in the DB or a Constant in config
        $frequencies    = ['puntual','semanal','quincenal','mensual','bimensual','trimestral','semestral','anual'];

        return view('livewire.entries-edit', [
            'categories'        => $categories,
            'tags'              => $tags,
            'frequencies'       => $frequencies,
        ]);
    }
}
