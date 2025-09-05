<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\EntryService;

class Balances extends Component
{
    use WithPagination;

    //protected $paginationTheme = "bootstrap";
    public $orderColumn = "balances.id";
    public $sortOrder = "desc";
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';
    public $search = "";
    public $perPage = 25;

    // filters    
    public $showFilters = 1;

    public $dateFrom = '';
    public $initialDateFrom;
    public $dateTo = '';
    public $initialDateTo;

    public $valueFrom;
    public $initialValueFrom;
    public $valueTo;
    public $initialValueTo;

    public $sour = 0;
    public $userID = 0;

    public $isAdmin = 0;

    // multiple batch selections
    public $selections = [];   
    
    public $listEntriesIds = [];
    public $okselections = [];

    // CRITERIA
    public $criteria = [];

    public function boot(
        EntryService $entryService,
    ) {
        $this->entryService = $entryService;
    }

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

        // CRITERIA         
        if($this->search != '')
        {
            $this->criteria['search'] = $this->search;     

        }else{
            unset($this->criteria['search']);
        }

        if($this->userID != 0)
        {
            $this->criteria['user'] = $this->entryService->getUserName($this->userID);
        }else{
            unset($this->criteria['user']);
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
        
        if($this->sour != 0)
        {
            $this->criteria['source'] = $this->sour;
        }
        else{
            unset($this->criteria['source']);
        }  

    }

    public function mount() {       

        $this->isAdmin = Auth::user()->is_admin;

        ($this->isAdmin) ? $this->InitializeDataAdmin() : $this->InitializeDataUser();
    }

    public function InitializeDataUser()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Balance::where('user_id', Auth::id())->min('balances.date')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Balance::where('user_id', Auth::id())->min('balances.date')));
        $this->dateTo = date('Y-m-d', strtotime(Balance::where('user_id', Auth::id())->max('balances.date')));
        $this->initialDateTo = date('Y-m-d', strtotime(Balance::where('user_id', Auth::id())->max('balances.date')));

        $this->valueFrom = Balance::where('user_id', Auth::id())->min('total');
        $this->initialValueFrom = Balance::where('user_id', Auth::id())->min('total');
        $this->valueTo = Balance::where('user_id', Auth::id())->max('total');
        $this->initialValueTo = Balance::where('user_id', Auth::id())->max('total');
    }

    public function InitializeDataAdmin()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Balance::min('balances.date')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Balance::min('balances.date')));
        $this->dateTo = date('Y-m-d', strtotime(Balance::max('balances.date')));
        $this->initialDateTo = date('Y-m-d', strtotime(Balance::max('balances.date')));

        $this->valueFrom = Balance::min('total');
        $this->initialValueFrom = Balance::min('total');
        $this->valueTo = Balance::max('total');
        $this->initialValueTo = Balance::max('total');
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
        $this->dateFrom = date('Y-m-d', strtotime(Balance::where('user_id', Auth::id())->min('balances.date')));
        $this->dateTo = date('Y-m-d', strtotime(Balance::where('user_id', Auth::id())->max('balances.date')));        
        $this->valueFrom = Balance::where('user_id', Auth::id())->min('total');
        $this->valueTo = Balance::where('user_id', Auth::id())->max('total');
        $this->sour = 0;
        $this->userID = 0;
        $this->criteria = [];
    }

    public function clearFiltersAdmin()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Balance::min('balances.date')));
        $this->dateTo = date('Y-m-d', strtotime(Balance::max('balances.date')));        
        $this->valueFrom = Balance::min('total');
        $this->valueTo = Balance::max('total');
        $this->sour = 0;
        $this->userID = 0;
        $this->criteria = [];
    }

    public function clearSearch()
    {
        $this->search = "";
        unset($this->criteria['search']);
    }

    public function clearFilterDate()
    {
        ($this->isAdmin) ? $this->clearFilterDateAdmin() : $this->clearFilterDateUser();
    }
    
    public function clearFilterDateUser()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Balance::where('user_id', Auth::id())->min('balances.date')));
        $this->dateTo = date('Y-m-d', strtotime(Balance::where('user_id', Auth::id())->max('balances.date')));
        unset($this->criteria['date']);
    }

    public function clearFilterDateAdmin()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Balance::min('balances.date')));
        $this->dateTo = date('Y-m-d', strtotime(Balance::max('balances.date')));
        unset($this->criteria['date']);
    }

     public function clearFilterValue()
    {
        ($this->isAdmin) ? $this->clearFilterAdmin() : $this->clearFilterValueUser();
    }

    public function clearFilterValueUser()
    {
        $this->valueFrom = Balance::where('user_id', Auth::id())->min('total');
        $this->valueTo = Balance::where('user_id', Auth::id())->max('total');
        unset($this->criteria['value']);
    }

    public function clearFilterAdmin()
    {
        $this->valueFrom = Balance::min('total');
        $this->valueTo = Balance::max('total');
        unset($this->criteria['value']);
    }

     public function clearFilterSource()
    {
        $this->sour = 0;
    }

    public function clearFilterUser()
    {
        $this->userID = 0;
    }

    // BULK ACTIONS

    public function bulkClear()
    {
        $this->selections = [];
    }

    public function bulkDelete()
    {
        foreach ($this->selections as $selection) {
            $balance = Balance::find($selection);
            $balance->delete();
        }

        return to_route('balances.index')/* ->with('message', 'balances successfully deleted.') */;
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

        $users = User::orderby('name', 'ASC')->get();
        $sources = Balance::orderby('source', 'ASC')->select('source')->distinct()->get();

         /* resticted access - user can only access his balances, Admin can access all the balances */
        if (Auth::user()->is_admin) {
            $data = Balance::orderby($this->orderColumn, $this->sortOrder)->select('*');    
        }  
        else {
            $data = Balance::orderby($this->orderColumn, $this->sortOrder)->where('user_id', '=', Auth::id())->select('*');
        }  

        /* -------------------------------- FILTERS --------------------------- */

        // user filter
        if ($this->userID != 0) {
            // TODO: When there is a filter, check if the current selections ids are in the current
            // filtered data, if there are not, take the id from selections                        
            $data = $data->where('user_id', '=', $this->userID);                        
        }

        // interval date filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $data = $data->whereDate('balances.date', '>=', $this->dateFrom)
                ->whereDate('balances.date', '<=', $this->dateTo);
            }
            else {
                //dd('errorcito');
            }
        }

        // interval value filter   
        if ($this->valueFrom <= $this->valueTo) {
            $data = $data->whereBetween('total', [$this->valueFrom, $this->valueTo]);
        }

        // source filter
        if (!empty($this->sour)) {
            $data = $data->where('source', '=', $this->sour);
        }
        

        if (!empty($this->search)) {
            $found = $data->where('name', "like", "%" . $this->search . "%")->count();
        }

        $total = $data->count();

        // TEST SELECTIONS IN FILTERS
        $dataEntriesIds = clone $data;

        $this->listEntriesIds = $dataEntriesIds->pluck('id')->toArray();

        $this->okselections = array_intersect($this->listEntriesIds, $this->selections);

        $data = $data->paginate($this->perPage);

        return view('livewire.balances', [
            'listEntriesIds' => $this->listEntriesIds,
            'okselections'  => $this->okselections,
            'balances'      => $data,
            'users'         => $users,
            'sources'       => $sources,
            'found'         => $found,
            'column'        => $this->orderColumn,
            'total'         => $total,
        ]);
    }

    
}
