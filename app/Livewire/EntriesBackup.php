<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;


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

    public $freq = '';
    public $compa = '';
    public $cat = 0;
    public $bal = 0;
    public $tag = 0;
    public $userID = 0;

    public $isAdmin = 0;


    // multiple batch selections
    public $selections = [];   
    
    public $listEntriesIds = [];
    public $okselections = [];

    public function updated()
    {
        $this->resetPage();

        // TEST - Check if the selection exists in the current filtered entries
        if($this->selections != [])
        {
            // convert string to integer values in the array of IDs selected
            // foreach($this->selections as $key => $selection)
            // {                   
            //     $this->selections[$key] = intval($selection);
            // }
            foreach($this->selections as $key => $selection)
            {                   
                $this->selections[$key] = intval($selection);
                
            }
            //dd($this->selections);
            //dd($this->listEntriesIds);
        }
    }

    public function mount() {       

        $this->isAdmin = Auth::user()->is_admin;

        ($this->isAdmin) ? $this->InitializeDataAdmin() : $this->InitializeDataUser();
    }

    public function InitializeDataUser()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('date')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('date')));
        $this->initialDateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('date')));

        $this->valueFrom = Entry::where('user_id', Auth::id())->min('value');
        $this->initialValueFrom = Entry::where('user_id', Auth::id())->min('value');
        $this->valueTo = Entry::where('user_id', Auth::id())->max('value');
        $this->initialValueTo = Entry::where('user_id', Auth::id())->max('value');
    }

    public function InitializeDataAdmin()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::min('date')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Entry::min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::max('date')));
        $this->initialDateTo = date('Y-m-d', strtotime(Entry::max('date')));

        $this->valueFrom = Entry::min('value');
        $this->initialValueFrom = Entry::min('value');
        $this->valueTo = Entry::max('value');
        $this->initialValueTo = Entry::max('value');
    }

    public function activateFilter()
    {
        $this->showFilters++;
    }

    // Clear Filters

    public function clearFilters()
    {
        ($this->isAdmin) ? $this->clearFiltersAdmin() : $this->clearFiltersUser();
    }

    public function clearFiltersUser()
    {
        $this->types = 2;
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('date')));        
        $this->valueFrom = Entry::where('user_id', Auth::id())->min('value');
        $this->valueTo = Entry::where('user_id', Auth::id())->max('value');
        $this->freq = '';
        $this->compa = '';
        $this->cat = 0;
        $this->bal = 0;
        $this->tag = 0;
        $this->userID = 0;
    }

    public function clearFiltersAdmin()
    {
        $this->types = 2;
        $this->dateFrom = date('Y-m-d', strtotime(Entry::min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::max('date')));        
        $this->valueFrom = Entry::min('value');
        $this->valueTo = Entry::max('value');
        $this->freq = '';
        $this->compa = '';
        $this->cat = 0;
        $this->bal = 0;
        $this->tag = 0;
        $this->userID = 0;
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
        ($this->isAdmin) ? $this->clearFilterDateAdmin() : $this->clearFilterDateUser();
    }
    
    public function clearFilterDateUser()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('date')));
    }

    public function clearFilterDateAdmin()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::max('date')));
    }

    public function clearFilterValue()
    {
        ($this->isAdmin) ? $this->clearFilterAdmin() : $this->clearFilterValueUser();
    }

    public function clearFilterValueUser()
    {
        $this->valueFrom = Entry::where('user_id', Auth::id())->min('value');
        $this->valueTo = Entry::where('user_id', Auth::id())->max('value');
    }

    public function clearFilterAdmin()
    {
        $this->valueFrom = Entry::min('value');
        $this->valueTo = Entry::max('value');
    }

    public function clearFilterFrequency()
    {
        $this->freq = '';
    }

    public function clearFilterCompany()
    {
        $this->compa = '';
    }

    public function clearFilterCategory()
    {
        $this->cat = 0;
    }

    public function clearFilterBalance()
    {
        $this->bal = 0;
    }

    public function clearFilterTag()
    {
        $this->tag = 0;
    }

    public function clearFilterUser()
    {
        $this->userID = 0;
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
            //dd($element);
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
        $balances = Balance::orderby('name', 'ASC')->get();
        $tags = Tag::orderby('name', 'ASC')->get();
        $users = User::orderby('name', 'ASC')->get();
        $frequencies = Entry::orderby('frequency', 'ASC')->select('frequency')->distinct()->get();
        $companies = Entry::orderby('company', 'ASC')->select('company')->get();

         /* resticted access - user can only access his entries, Admin can access all the entries */
        if ($this->isAdmin) {
            $data = Entry::orderby($this->orderColumn, $this->sortOrder)->select('*');    
        }  
        else {
            $data = Entry::orderby($this->orderColumn, $this->sortOrder)->where('user_id', '=', Auth::id())->select('*');
        }        

        // $soft = Entry::orderby($this->orderColumn, $this->sortOrder)->onlyTrashed()->select('*');

        // dd($soft->count());

        // user filter
        if ($this->userID != 0) {
            // TODO: When there is a filter, check if the current selections ids are in the current
            // filtered data, if there are not, take the id from selections
                        
            $data = $data->where('user_id', '=', $this->userID);            


            
        }

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

        // frequency filter
        if (!empty($this->freq)) {
            $data = $data->where('frequency', '=', $this->freq);
        }

        // company filter
        if (!empty($this->compa)) {
            $data = $data->where('company', '=', $this->compa);
        }

        // category filter
        if ($this->cat != 0) {
            $data = $data->where('entries.category_id', '=', $this->cat);
        }

        // balance filter
        if ($this->bal != 0) {
            $data = $data->where('entries.balance_id', '=', $this->bal);
        }

        // tag filter
        if ($this->tag != 0) {
            //TODO: TAG FILTER, filter but not show the tag name
             $data = $data
             ->join('entry_tag', 'entries.id', '=', 'entry_tag.entry_id')
             ->where('entry_tag.tag_id', '=', $this->tag);
        }        

        // search
        if (!empty($this->search)) {
            $found = $data->where('title', 'like', '%' . $this->search . '%')->count();
        }

        $total = $data->count();
        $dataRaw =  clone $data;

        // TEST SELECTIONS IN FILTERS
        $dataEntriesIds = clone $data;

        $this->listEntriesIds = $dataEntriesIds->pluck('id')->toArray();

        $this->okselections = array_intersect($this->listEntriesIds, $this->selections);
        

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
            'listEntriesIds' => $this->listEntriesIds,
            'okselections'  => $this->okselections,
            'entriesRaw'    => $dataRaw,
            'entries'       => $data,
            'categories'    => $categories,
            'balances'      => $balances,
            'tags'          => $tags,
            'users'         => $users,
            'frequencies'   => $frequencies,
            'companies'     => $companies,
            'found'         => $found,
            'column'        => $this->orderColumn,
            'total'         => $total            
        ]);
    }

    
}
