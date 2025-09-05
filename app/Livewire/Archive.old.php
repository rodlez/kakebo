<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use App\Models\User;
use App\Services\FileService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Archive extends Component
{
    use WithPagination;

    // Dependency Injection to use the Service
    protected FileService $fileService;
    
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

    public $userID = 0;

    // multiple batch selections
    public $selections = [];

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        FileService $fileService,
    ) {
        $this->fileService = $fileService;
    }    

    public function updated()
    {
        $this->resetPage();
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
        $this->compa = '';
        $this->cat = 0;
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
        $this->dateFrom = date('Y-m-d', strtotime(Entry::onlyTrashed()->min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::onlyTrashed()->max('date')));
    }    

    public function clearFilterValue()
    {
        $this->valueFrom = Entry::onlyTrashed()->min('value');
        $this->valueTo = Entry::onlyTrashed()->max('value');
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

    public function clearFilterUser()
    {
        $this->userID = 0;
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
                        $this->fileService->deleteFiles($files);
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
        $users = User::orderby('name', 'ASC')->get();
        $companies = Entry::onlyTrashed()->orderby('company', 'ASC')->select('company')->get();
       
        //$data = Entry::orderby($this->orderColumn, $this->sortOrder)->onlyTrashed()->select('*');      

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
            'entries.updated_at as updated_at',
        )
            ->join('categories', 'entries.category_id', '=', 'categories.id')
            ->join('balances', 'entries.balance_id', '=', 'balances.id')
            ->join('entry_tag', 'entries.id', '=', 'entry_tag.entry_id')
            ->onlyTrashed()
            ->distinct('entries.id')
            ->orderby($this->orderColumn, $this->sortOrder);
        
        //dd($data->count());
            
        // user filter
        if ($this->userID != 0) {
            $data = $data->where('user_id', '=', $this->userID);
        }
        
        // types filter
        if ($this->types != 2) {
            $data = $data->where('type', '=', $this->types);
        }

        // // interval date filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $data = $data->where('entries.date', '>=', $this->dateFrom)
                ->where('entries.date', '<=', $this->dateTo);
                //$data = $data->whereBetween('entries.date', [$this->dateFrom, $this->dateTo]);
            }
            else {
                dd('errorcito');
            }
        }
//var_dump($this->valueFrom);
//var_dump($this->valueTo);
        // interval value filter   
        if ($this->valueFrom <= $this->valueTo) {
            $data = $data->whereBetween('value', [$this->valueFrom, $this->valueTo]);
        }
//dd($data->count());
        // company filter
        if (!empty($this->compa)) {
            $data = $data->where('company', '=', $this->compa);
        }

        // category filter
        if ($this->cat != 0) {
            $data = $data->where('category_id', '=', $this->cat);
        }

        // // tag filter
        // if ($this->tag != 0) {
        //     //TODO: TAG FILTER
        //     // $data = $data
        //     // ->join('entry_tag', 'entries.id', '=', 'entry_tag.entry_id')
        //     // ->where('entry_tag.tag_id', '=', $this->tag);
        // }        

         // search
        if (!empty($this->search)) {
           // TODO: Search using COLLECTIONS AND FILTERS AND MACRO            
            $found = $data->where('title', 'like', '%' . $this->search . '%')->count();
        }

        $total = $data->count();       
        $data = $data->paginate($this->perPage);
        //dd($data->count());

        return view('livewire.archive', [
            // Styles
            'underlineMenuHeader'   => 'border-b-2 border-b-slate-600',
            'textMenuHeader'        => 'hover:text-slate-400',
            'bgMenuColor'           => 'bg-slate-800',
            'menuTextColor'         => 'text-slate-800',
            'focusColor'            => 'focus:ring-slate-500 focus:border-slate-500',
            // Data
            'entries'       => $data,
            'categories'    => $categories,
            'tags'          => $tags,
            'users'         => $users,
            'companies'     => $companies,
            'found'         => $found,
            'column'        => $this->orderColumn,
            'total'         => $total            
        ]);
    }
}
