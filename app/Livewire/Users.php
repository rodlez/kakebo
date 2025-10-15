<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    //protected $paginationTheme = "bootstrap";
    public $orderColumn = "users.id";
    public $sortOrder = "desc";
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';    
    public $perPage = 25;

    // search
    public $showSearch = 1;
    public $search = "";
    public $searchType = 'name';

    // small or full view of the entry table
    public $smallView = false;

    // font size table
    public $smallFont = true;

    // filters    
    public $showFilters = 0;

    public $dateFrom = '';
    public $initialDateFrom;
    public $dateTo = '';
    public $initialDateTo;
  
    public $isAdmin = 2;

    // multiple batch selections
    public $selections = [];   
    
    public $listEntriesIds = [];
    public $okselections = [];

    public function updated()
    {
        $this->resetPage();
        // Check if the selection exists in the current filtered entries
        // Convert array of selections from string to integer
        if($this->selections != [])
        {           
            foreach($this->selections as $key => $selection)
            {                   
                $this->selections[$key] = intval($selection);
                
            }
        }
    }

    public function mount() {       

        $this->dateFrom = date('Y-m-d', strtotime(User::min('created_at')));
        $this->initialDateFrom = date('Y-m-d', strtotime(User::min('created_at')));
        $this->dateTo = date('Y-m-d', strtotime(User::max('created_at')));
        $this->initialDateTo = date('Y-m-d', strtotime(User::max('created_at')));
    }

    public function activateSmallView(bool $activate)
    {
        $this->smallView = $activate;
    }

    public function activateSmallFont(bool $activate)
    {
        $this->smallFont = $activate;
    }

    public function activateFilter()
    {
        $this->showFilters++;
    }

    public function activateSearch()
    {
        $this->showSearch++;
    }

    public function clearFilters()
    {
        $this->isAdmin = 2;
        $this->dateFrom = date('Y-m-d', strtotime(User::min('created_at')));
        $this->dateTo = date('Y-m-d', strtotime(User::max('created_at')));                
    }

    public function clearFilterDate()
    {
        $this->dateFrom = date('Y-m-d', strtotime(User::min('created_at')));
        $this->dateTo = date('Y-m-d', strtotime(User::max('created_at')));
    }

    public function clearFilterIsAdmin()
    {
        $this->isAdmin = 2;
    }

    public function clearSearch()
    {
        $this->search = "";
        $this->searchType = 'name';
    }

    // BULK ACTIONS

    public function bulkClear()
    {
        $this->selections = [];
    }

    public function bulkDelete()
    {
        dd('delete user');
        foreach ($this->selections as $selection) {
            $balance = User::find($selection);
            $balance->delete();
        }

        return to_route('users.index')/* ->with('message', 'balances successfully deleted.') */;
    }

    public function resetAll()
    {
        $this->clearFilters();
        $this->clearSearch();
        $this->bulkClear();
    }

    public function sorting($columnName = "")
    {
        $caretOrder = "up";
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

        $data = User::orderby($this->orderColumn, $this->sortOrder)->select('*');           

        // ------ SEARCH ------
        if (!empty($this->search)) {
            $data = $data->where($this->searchType, "like", "%" . trim($this->search) . "%");
            $found = $data->count();
        }

        /* -------------------------------- FILTERS --------------------------- */

        // admin filter
        if ($this->isAdmin != 2) {
            // TODO: When there is a filter, check if the current selections ids are in the current
            // filtered data, if there are not, take the id from selections   
            //dd($this->isAdmin);  
            if ($this->isAdmin == 0) {                               
                $data = $data->where('is_admin', '=', null);                        
            }
            else {
                $data = $data->where('is_admin', '=', 1);                        
            }
        }

        // interval created_at filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $data = $data->whereDate('users.created_at', '>=', $this->dateFrom)
                ->whereDate('users.created_at', '<=', $this->dateTo);
            }
            else {
                //dd('errorcito');
            }
        }

        $total = $data->count();
        $dataRaw =  clone $data;

        // TEST SELECTIONS IN FILTERS
        $dataEntriesIds = clone $data;

        $this->listEntriesIds = $dataEntriesIds->pluck('id')->toArray();

        $this->okselections = array_intersect($this->listEntriesIds, $this->selections);

        $data = $data->paginate($this->perPage);

        return view('livewire.users', [
            'listEntriesIds'    => $this->listEntriesIds,
            'okselections'      => $this->okselections,
            'usersRaw'          => $dataRaw,
            'users'             => $data,
            'found'             => $found,
            'column'            => $this->orderColumn,
            'total'             => $total,
        ]);
    }

}
