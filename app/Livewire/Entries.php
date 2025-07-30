<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Url;

class Entries extends Component
{
    use WithPagination;

    // Dependency Injection to use the Service
    
    
    // order and pagination
    public $orderColumn = 'entries.id';
    public $sortOrder = 'desc';
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';
    public $perPage = 25;

    // search
    public $search = '';

    // filters    
    public $showFilters = 0;

    public $types = 2;

    public $dateFrom = '';
    public $initialDateFrom;
    public $dateTo = '';
    public $initialDateTo;

    public $valueFrom;
    public $initialValueFrom;
    public $valueTo;
    public $initialValueTo;

    public $compa = '';

    public $cat = 0;

    public $tag = 0;


    // multiple batch selections
    public $selections = [];
    

    public function updated()
    {
        $this->resetPage();
    }

    public function mount() {       
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('date')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('date')));
        $this->initialDateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('date')));

        $this->valueFrom = Entry::where('user_id', Auth::id())->min('value');
        $this->initialValueFrom = Entry::where('user_id', Auth::id())->min('value');
        $this->valueTo = Entry::where('user_id', Auth::id())->max('value');
        $this->initialValueTo = Entry::where('user_id', Auth::id())->max('value');
    }

    public function activateFilter()
    {
        $this->showFilters++;
    }

    // Clear Filters

    public function clearFilters()
    {
        $this->types = 2;
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('date')));        
        $this->valueFrom = Entry::where('user_id', Auth::id())->min('value');
        $this->valueTo = Entry::where('user_id', Auth::id())->max('value');
        $this->compa = '';
        $this->cat = 0;
        $this->tag = 0;
    }

    public function clearSearch()
    {
        $this->search = '';
    }

    public function clearFilterTypes()
    {
        $this->types = 2;
    }

     public function clearFilterDate()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('date')));
    }    

    public function clearFilterValue()
    {
        $this->valueFrom = Entry::where('user_id', Auth::id())->min('value');
        $this->valueTo = Entry::where('user_id', Auth::id())->max('value');
    }

    public function clearFilterCompany()
    {
        $this->compa = '';
    }

    public function clearFilterCategory()
    {
        $this->cat = 0;
    }

    public function clearFilterTag()
    {
        $this->tag = 0;
    }
    

    // Bulk Actions

    public function bulkClear()
    {
        $this->selections = [];
    }

    public function bulkDelete()
    {
        //dd($this->selections);
        foreach ($this->selections as $selection) {
            $element = Entry::find($selection);
            dd($element);
            $element->delete();
        }
        
        return to_route('entries.index')->with('message', 'Entries deleted.');
        //return to_route('entries')->with('message', __('generic.bulkDelete')); 
        //return $this->portfolioService->bulkDeletePortfolios($this->selections);
    }

    public function sorting($columnName = '')
    {
        $caretOrder = 'up';
        if ($this->sortOrder == 'asc') {
            $this->sortOrder = 'desc';
            $caretOrder = 'down';
        } else {
            $this->sortOrder = 'asc';
            $caretOrder = 'up';
        }

        $this->sortLink = '<i class="fa-solid fa-caret-' . $caretOrder . '"></i>';
        $this->orderColumn = $columnName;
    }

    

    public function render()
    {
       
        $found = 0;

        $categories = Category::orderby('name', 'ASC')->get();

        $tags = Tag::orderby('name', 'ASC')->get();

        $companies = Entry::orderby('company', 'ASC')->select('company')->get();

        $data = Entry::orderby($this->orderColumn, $this->sortOrder)->select('*');

        // $soft = Entry::orderby($this->orderColumn, $this->sortOrder)->onlyTrashed()->select('*');

        // dd($soft->count());

        // types filter
        if ($this->types != 2) {
            $data = $data->where('type', '=', $this->types);
        }

        // interval date filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $data = $data->whereDate('date', '>=', $this->dateFrom)
                ->whereDate('date', '<=', $this->dateTo);
            }
            else {
                //dd('errorcito');
            }
        }

        // interval value filter   
        if ($this->valueFrom <= $this->valueTo) {
            $data = $data->whereBetween('value', [$this->valueFrom, $this->valueTo]);
        }

        // company filter
        if (!empty($this->compa)) {
            $data = $data->where('company', '=', $this->compa);
        }

        // category filter
        if ($this->cat != 0) {
            $data = $data->where('entries.category_id', '=', $this->cat);
        }

        // tag filter
        if ($this->tag != 0) {
            //TODO: TAG FILTER, filter but not show the tag name
            // $data = $data
            // ->join('entry_tag', 'entries.id', '=', 'entry_tag.entry_id')
            // ->where('entry_tag.tag_id', '=', $this->tag);
        }        

        // search
        if (!empty($this->search)) {
            $found = $data->where('title', 'like', '%' . $this->search . '%')->count();
        }

        $total = $data->count();
        $data = $data->paginate($this->perPage);

        return view('livewire.entries', [
            // Styles
            'underlineMenuHeader'   => 'border-b-2 border-b-slate-600',
            'textMenuHeader'        => 'hover:text-slate-400',
            'bgMenuColor'           => 'bg-slate-800',
            'menuTextColor'         => 'text-slate-800',
            'focusColor'            => 'focus:ring-slate-500 focus:border-slate-500',
            // Data
            //'soft'          => $soft,
            'entries'       => $data,
            'categories'    => $categories,
            'tags'          => $tags,
            'companies'     => $companies,
            'found'         => $found,
            'column'        => $this->orderColumn,
            'total'         => $total            
        ]);
    }

    
}
