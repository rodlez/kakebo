<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Models



class EntryService
{

    /**
     * Check if the role of the current User.
     * User can only access his entries, Admin can access all the entries 
     */
    public function authorization(Entry $entry)
    {         
        if(!Auth::user()->is_admin) {
            if ($entry->user_id !== Auth::user()->id) {
                abort(403);
            }
        }  
    }    

    /**
     *  Get array with the name of the tags for this entry
     * 
     * @param Entry $entry
     * @param string $separator Value to separate between tags (- / *) 
     */
    public function getEntryTagsNames(Entry $entry): array
    {
        $tags = $entry->tags;        
        $result = [];

        foreach ($tags as $tag) {         
                $result[] = $tag->name;         
        }

        return $result;
    }

    public function getStatsTime(string $time): mixed
    {
        $data = Entry::where('user_id', '=', Auth::id())->get();

        if ($time == 'today') 
        {                                
            $expenses = $data->whereBetween('date', [now()->subDays(1), now()])->where('type', '=', 0)->sum('value');
            $income = $data->whereBetween('date', [now()->subDays(1), now()])->where('type', '=', 1)->sum('value');
        }

        if ($time == 'week') 
        {                                
            $expenses = $data->whereBetween('date', [now()->subDays(7), now()])->where('type', '=', 0)->sum('value');
            $income = $data->whereBetween('date', [now()->subDays(7), now()])->where('type', '=', 1)->sum('value');
        }

        if ($time == 'month') 
        {                                
            $expenses = $data->whereBetween('date', [now()->subDays(30), now()])->where('type', '=', 0)->sum('value');
            $income = $data->whereBetween('date', [now()->subDays(30), now()])->where('type', '=', 1)->sum('value');
        }
        
        return $income - $expenses;
    }
    
    /**
     * Get the tag names given an array with the tag ids
     */

    public function getTagNames(array $tags): array
    {
        $tagsNames = [];
        foreach ($tags as $key => $value) {
            $tagInfo = Tag::find($value);
            $tagsNames[] = $tagInfo->name;
        }
        return $tagsNames;
    }

    /**
     * Get user name
     */

    public function getUserName(int $userID): string
    {
        return User::where('id','=',$userID)->value('name');        
    }

    /**
     * Get Criteria for Export Excel filename
     * Given an associative array, sort and return a string
     */

    public function getCriteriaFilename(array $criteriaSelection): string
    {
        ksort($criteriaSelection);
        //$criterin = implode('_', $criterias);
        //dd($criterias);
        $resultado = '';
        foreach ($criteriaSelection as $key => $value) {
            $resultado .= $key . '_';
            $resultado .= $value . '_';
        }
        $resultado = str_replace(' ','-',$resultado);
        $resultado = str_replace(',','',$resultado); 
        
        return $resultado;
    }

    /**
     *  Search and extract values from an array based on a key
    */

    public function getArrayValues(array $data, string $keyName): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[] = $value[$keyName];
        }

        return $result;
    }

    /**
     *  
    */

    public function getIncomeExpenses(array $data): array
    {
        $result = [];
        $result['incomes'] = 0;
        $result['numberIncomes'] = 0;
        $result['expenses'] = 0;
        $result['numberExpenses'] = 0;

        foreach ($data as $key => $value) 
        {
            if($value['type'] == 1)
            {
                $result['incomes'] = $result['incomes'] + $value['value'];
                $result['numberIncomes']++;
            } else
            {
                $result['expenses'] = $result['expenses'] + $value['value'];
                $result['numberExpenses']++;
            }            
        }

        return $result;
    }

    public function getPayments(array $data): array
    {
        $result = [];
        $result['sourceCash'] = 0;
        $result['sourceCard'] = 0;
        $result['sourceStocks'] = 0;

        foreach ($data as $key => $value) 
        {
            if($value['balance_source'] == 'cash')
            {                
                $result['sourceCash']++;
            }
            if($value['balance_source'] == 'card')
            {                
                $result['sourceCard']++;
            }
            if($value['balance_source'] == 'stocks')
            {                
                $result['sourceStocks']++;
            }            
        }

        return $result;
    }


    public function getStatsArrayOrder(array $data, string $keyName): array
    {
        $result['total'] = 0;
        $list = [];

        $list = $this->getArrayValues($data,$keyName);
        natcasesort($list);
        
        $result['total'] = count(array_unique($list));
        $list = array_count_values($list);        

        // Combine key - values of the array to a single array with name and number of apperances
        $listCombined = [];

        foreach ($list as $key => $value) {
            $listCombined[] = $key . ' (' . $value . ')';
        }

        $result['list'] = $listCombined;

        return $result;

    }

    /**
     * Stats for the current entries found 
     * 
     */

    public function getTotalStats(array $data): array
    {
        $result = [];
        
        if($data == [])
        {
            return $result;
        }
       
        // Users
        $users = $this->getArrayValues($data,'user_id');
        $result['users'] = count(array_unique($users));

        // Incomes & Expenses
        $balanceStats = $this->getIncomeExpenses($data);        
        $result['incomes'] = $balanceStats['incomes'];
        $result['numberIncomes'] = $balanceStats['numberIncomes'];
        $result['expenses'] = $balanceStats['expenses'];
        $result['numberExpenses'] = $balanceStats['numberExpenses'];

        // Dates
        $dates = $this->getArrayValues($data,'date');
        $result['days'] = count(array_unique($dates));
        $result['dateFrom'] = min(array_unique($dates));
        $result['dateTo'] = max(array_unique($dates));
        
        // Payments
        $paymentStats = $this->getPayments($data); 
        $result['sourceCash'] = $paymentStats['sourceCash'];
        $result['sourceCard'] = $paymentStats['sourceCard'];
        $result['sourceStocks'] = $paymentStats['sourceStocks'];        
       
        // Accounts        
        $accountsStats = $this->getStatsArrayOrder($data,'balance_name');
        $result['numberAccounts'] = $accountsStats['total'];
        $result['accounts'] = $accountsStats['list'];
                
        // Companies        
        $companiesStats = $this->getStatsArrayOrder($data,'company');
        $result['numberCompanies'] = $companiesStats['total'];
        $result['companies'] = $companiesStats['list'];

        // Categories        
        $categoriesStats = $this->getStatsArrayOrder($data,'category_name');
        $result['numberCategories'] = $categoriesStats['total'];
        $result['categories'] = $categoriesStats['list'];

        return $result;
        
    }

}