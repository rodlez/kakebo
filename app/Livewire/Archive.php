<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use App\Models\User;
use App\Services\EntryService;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Archive extends Component
{
    use WithPagination;

    // Dependency Injection to use the Service
    protected EntryService $entryService;     
    protected FileService $fileService; 
    
    // order and pagination
    public $orderColumn = 'entries.id';
    public $sortOrder = 'desc';
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';
    public $perPage = 25;

    // search
    public $showSearch = 1;
    public $search = '';
    public $searchType = 'company';

    // stats
    public $showStats = 1;
    
    // small or full view of the entry table
    public $smallView = false;

    // font size table
    public $smallFont = true;

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

    public $freq = 0;
    public $sour = 0;
    public $compa = 0;
    public $cat = 0;
    public $bal = 0;
    public $tag = 0;
    public $selectedTags = [];
    public $tagNames = [];
    public $userID = 0;

    // in archive user is ALWAYS an admin
    //public $isAdmin = 0;


    // multiple batch selections
    public $selections = [];       
    public $listEntriesIds = [];
    public $okselections = [];

    // CRITERIA
    public $criteria = [];

    public function boot(
        EntryService $entryService,
        FileService $fileService
    ) {
        $this->entryService = $entryService;
        $this->fileService = $fileService;
    }

    public function updated()
    {
        $this->resetPage();

        // Check if the selection exists in the current filtered entries
        if($this->selections != [])
        {
            // convert string to integer values in the array of IDs selected            
            foreach($this->selections as $key => $selection)
            {                   
                $this->selections[$key] = intval($selection);
                
            }            
        }

        // CRITERIA         
        if($this->search != '')
        {
            $this->criteria['search'] = $this->search;     
            
            switch ($this->searchType) {
                case 'entries.id':
                    $this->criteria['searchType'] = 'Id';
                    break;
                case 'balances.name':
                    $this->criteria['searchType'] = 'Account';
                    break;                
                default:
                    $this->criteria['searchType'] = $this->searchType;
                    break;
            }

        }else{
            unset($this->criteria['search']);
            unset($this->criteria['searchType']);
        }

        if($this->userID != 0)
        {
            $this->criteria['user'] = $this->entryService->getUserName($this->userID);
        }else{
            unset($this->criteria['user']);
        }   

        if($this->types != 2)
        {
            ($this->types == 1) ? $this->criteria['types'] = 'Income' : $this->criteria['types'] = 'Expense';
        }
        else{
            unset($this->criteria['types']);
        }    

        if($this->initialDateTo != $this->dateTo || $this->initialDateFrom != $this->dateFrom )
        {
            $this->criteria['date'] = date('d-m-Y', strtotime($this->dateFrom)) . ' to ' . date('d-m-Y', strtotime($this->dateTo));
        }
        else{
            unset($this->criteria['date']);
        } 

        if($this->initialValueTo != $this->valueTo || $this->initialValueFrom != $this->valueFrom)
        {
            $this->criteria['value'] = $this->valueFrom . ' to ' . $this->valueTo;
        }
        else{
            unset($this->criteria['value']);
        } 

        if($this->cat != 0)
        {
            $this->criteria['category'] = $this->cat;
        } 
        else{
            unset($this->criteria['category']);
        } 

        if($this->bal != 0)
        {
            $this->criteria['balance'] = $this->bal;
        }        
        else{
            unset($this->criteria['balance']);
        }

        if($this->freq != 0)
        {
            $this->criteria['frequency'] = $this->freq;
        }
        else{
            unset($this->criteria['frequency']);
        }

        if($this->sour != 0)
        {
            $this->criteria['source'] = $this->sour;
        }
        else{
            unset($this->criteria['source']);
        }  

        if($this->compa != 0)
        {
            $this->criteria['company'] = $this->compa;
        }
        else{
            unset($this->criteria['company']);
        }  

        if(!in_array('0', $this->selectedTags) && count($this->selectedTags) != 0)
        {
            $this->tagNames = $this->entryService->getTagNames($this->selectedTags);
            $this->criteria['tags'] = implode(', ', $this->tagNames);
        }
        else{
            unset($this->criteria['tags']);
        }  
    }

    public function mount() {       

        $this->dateFrom = date('Y-m-d', strtotime(Entry::onlyTrashed()->min('date')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Entry::onlyTrashed()->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::onlyTrashed()->max('date')));
        $this->initialDateTo = date('Y-m-d', strtotime(Entry::onlyTrashed()->max('date')));

        $this->valueFrom = Entry::onlyTrashed()->min('value');
        $this->initialValueFrom = Entry::onlyTrashed()->min('value');
        $this->valueTo = Entry::onlyTrashed()->max('value');
        $this->initialValueTo = Entry::onlyTrashed()->max('value');
    }
    

    public function activateSmallView(bool $activate)
    {
        $this->smallView = $activate;
    }

    public function activateSmallFont(bool $activate)
    {
        $this->smallFont = $activate;
    }

    public function activateSearch()
    {
        $this->showSearch++;
    }

     public function activateStats()
    {
        $this->showStats++;
    }

    public function activateFilter()
    {
        $this->showFilters++;
    }

    // Clear Filters

    public function clearFilters()
    {
        $this->types = 2;
        $this->dateFrom = date('Y-m-d', strtotime(Entry::onlyTrashed()->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::onlyTrashed()->max('date')));        
        $this->valueFrom = Entry::onlyTrashed()->min('value');
        $this->valueTo = Entry::onlyTrashed()->max('value');
        $this->freq = 0;
        $this->sour = 0;
        $this->compa = 0;
        $this->cat = 0;
        $this->bal = 0;
        $this->tag = 0;
        $this->selectedTags = [];
        $this->userID = 0;
        $this->criteria = [];
    }   

    public function clearSearch()
    {
        $this->search = '';
        $this->searchType = 'title';
        unset($this->criteria['search']);
        unset($this->criteria['searchType']);
    }

    public function clearFilterTypes()
    {
        $this->types = 2;
        unset($this->criteria['types']);
    }

    public function clearFilterDate()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::onlyTrashed()->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::onlyTrashed()->max('date')));
        unset($this->criteria['date']);
    }   
    
    public function clearFilterValue()
    {
        $this->valueFrom = Entry::onlyTrashed()->min('value');
        $this->valueTo = Entry::onlyTrashed()->max('value');
        unset($this->criteria['value']);
    }   

    public function clearFilterFrequency()
    {
        $this->freq = 0;
        unset($this->criteria['frequency']);
    }

    public function clearFilterSource()
    {
        $this->sour = 0;
        unset($this->criteria['source']);
    }

    public function clearFilterCompany()
    {
        $this->compa = 0;
        unset($this->criteria['company']);
    }

    public function clearFilterCategory()
    {
        $this->cat = 0;
        unset($this->criteria['category']);
    }

    public function clearFilterBalance()
    {
        $this->bal = 0;
        unset($this->criteria['balance']);
    }

    public function clearFilterTag()
    {
        $this->tag = 0;
        $this->selectedTags = [];
        unset($this->criteria['tags']);
    }

    public function clearFilterUser()
    {
        $this->userID = 0;
        unset($this->criteria['user']);
    }
    
    // Bulk Actions

    public function bulkClear()
    {
        $this->selections = [];
    }

    public function bulkRestore()
    {
        foreach ($this->selections as $selection) {
            $element = Entry::onlyTrashed()->find($selection);
            $element->restore();
        }

        return to_route('archive.index')->with('message', 'Entries restored.');
    }

    public function bulkDelete()
    {
        foreach ($this->selections as $selection) {

            $entry = Entry::onlyTrashed()->find($selection);
            
            try {
                $files = $entry->files;
                // forceDelete method to permanently remove a soft deleted model from the database table
                $result = $entry->forceDelete();

                // If the Entry has been deleted, check if there is associated files and delete them.
                if ($result) {
                    if ($files->isNotEmpty()) {
                        //$this->fileService->deleteFiles($files);
                        // BETTER: Delete the directory with all the files inside
                        $folderPath = 'entryfiles/' . $entry->id;
                        $this->fileService->deleteFolder($folderPath);
                    }              
                } else {
                    return to_route('archive.index')->with('message', 'Error - Files from Entry (' . $entry->title . ') can not be deleted.');
                }
            } catch (Exception $e) {            
                return to_route('archive.index')->with('error', 'Error(' . $e->getCode() . ') - Entry (' . $entry->title . ') can not be deleted.');
            }

        }
        
        return to_route('archive.index')->with('message', 'Entries successfully deleted PERMANENTLY.');
    }

    public function resetAll()
    {
        $this->clearFilters();
        $this->clearSearch();
        $this->bulkClear();
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
        $sources = Balance::orderby('source', 'ASC')->select('source')->distinct()->get();
        $tags = Tag::orderby('name', 'ASC')->get();
        $users = User::orderby('name', 'ASC')->get();
        $frequencies = Entry::orderby('frequency', 'ASC')->select('frequency')->distinct()->get();
        $companies = Entry::orderby('company', 'ASC')->select('company')->get();
        
        // Main Selection, Join tables sports, sport_categories and sports_tag
        $data = Entry::select(
            'entries.id as id',
            'categories.name as category_name',
            'balances.name as balance_name',
            'balances.source as balance_source',
            'entries.title as title',
            'entries.user_id as user_id',
            'entries.type as type',
            'entries.company as company',
            'entries.value as value',
            'entries.frequency as frequency',
            'entries.date as date',
            'entries.info as info',
            'entries.created_at as created_at',
        )
            ->join('categories', 'entries.category_id', '=', 'categories.id')
            ->join('balances', 'entries.balance_id', '=', 'balances.id')
            ->join('entry_tag', 'entries.id', '=', 'entry_tag.entry_id')
            ->onlyTrashed()
            ->distinct('entries.id')
            ->orderby($this->orderColumn, $this->sortOrder);                 
        
        
        /* -------------------------------- FILTERS --------------------------- */

        // user filter
        if ($this->userID != 0) {
            // TODO: When there is a filter, check if the current selections ids are in the current
            // filtered data, if there are not, take the id from selections                        
            $data = $data->where('entries.user_id', '=', $this->userID);                        
        }

        // types filter
        if ($this->types != 2) {
            $data = $data->where('type', '=', $this->types);
        }

        // interval date filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $data = $data->whereDate('entries.date', '>=', $this->dateFrom)
                ->whereDate('entries.date', '<=', $this->dateTo);
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

        // payment filter
        if (!empty($this->sour)) {
            $data = $data->where('balances.source', '=', $this->sour);
        }

        // company filter
        if (!empty($this->compa)) {
            $data = $data->where('company', '=', $this->compa);
        }

        // category filter
        if ($this->cat != 0) {
            $data = $data->where('categories.name', '=', $this->cat);            
        }

        // account filter
        if ($this->bal != 0) {
            $data = $data->where('balances.name', '=', $this->bal);
        }

        // tag filter
        if ($this->tag != 0) {
            //TODO: TAG FILTER, filter but not show the tag name
             $data = $data
             ->join('entry_tag', 'entries.id', '=', 'entry_tag.entry_id')
             ->where('entry_tag.tag_id', '=', $this->tag);
        }                    

        // tags filter        
        if (!in_array('0', $this->selectedTags) && (count($this->selectedTags) != 0)) {
            $data = $data->whereIn('entry_tag.tag_id', $this->selectedTags);
        }

        
        // Search
        if (!empty($this->search)) {
            // trim search in case copy paste or start the search with whitespaces
            // search by id or name
            //$entries->orWhere('id', "like", "%" . $this->search . "%");
            //->orWhere('location', "like", "%" . $this->search . "%")
            $data = $data->where($this->searchType, "like", "%" . trim($this->search) . "%");
            $found = $data->count();
        }

        $total = $data->count();
        $dataRaw =  clone $data;      

        
        // STATS - deep copy, clone maintain the references  
        $dataStats = clone $data;
        $dataStats = $dataStats->get()->toArray();
        $stats = $this->entryService->getTotalStats($dataStats);


        // TEST SELECTIONS IN FILTERS
        $dataEntriesIds = clone $data;

        $this->listEntriesIds = $dataEntriesIds->pluck('id')->toArray();

        $this->okselections = array_intersect($this->listEntriesIds, $this->selections);
        
        // PAGINATION
        $data = $data->paginate($this->perPage);


        return view('livewire.archive', [
            // Styles
            'underlineMenuHeader'   => 'border-b-2 border-b-slate-600',
            'textMenuHeader'        => 'hover:text-slate-400',
            'bgMenuColor'           => 'bg-slate-800',
            'menuTextColor'         => 'text-slate-800',
            'focusColor'            => 'focus:ring-slate-500 focus:border-slate-500',
            // Data
            'listEntriesIds'    => $this->listEntriesIds,
            'okselections'      => $this->okselections,
            'entriesRaw'        => $dataRaw,
            'entries'           => $data,
            'categories'        => $categories,
            'balances'          => $balances,
            'sources'           => $sources,
            'tags'              => $tags,
            'users'             => $users,
            'frequencies'       => $frequencies,
            'companies'         => $companies,
            'found'             => $found,
            'column'            => $this->orderColumn,
            'total'             => $total,
            'tagNames'          => $this->tagNames,
            'stats'             => $stats,          
        ]);
    }

    
}
