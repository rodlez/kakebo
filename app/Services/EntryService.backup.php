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

    public function getArrayValues(array $data, string $key)
    {

    }

    /**
     * Stats for the current entries found 
     * 
     */

    public function getTotalStats(array $info): array
    {
        
        if($info == [])
        {
            return $result = [];
        }

        // result array
        $result = [];
        // Users
        $result['users'] = null;
        $users = [];

        foreach ($info as $key => $value) {
            $users[] = $value['user_id'];
        }
        dd($users);
        $result['users'] = count(array_unique($users));

        // Incomes & Expenses
        $result['incomes'] = 0;
        $result['numberIncomes'] = 0;
        $result['expenses'] = 0;
        $result['numberExpenses'] = 0;

        foreach ($info as $key => $value) 
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

        // Dates
        $result['days'] = null;        
        $result['dateFrom'] = null;
        $result['dateTo'] = null;
        $dates = [];

        foreach ($info as $key => $value) {
            $dates[] = $value['date'];
        }
        
        $result['days'] = count(array_unique($dates));
        $result['dateFrom'] = min(array_unique($dates));
        $result['dateTo'] = max(array_unique($dates));

        

        // Sources
        $result['sourceCash'] = 0;
        $result['sourceCard'] = 0;
        $result['sourceStocks'] = 0;

        foreach ($info as $key => $value) 
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
       
        // Accounts
        $result['numberAccounts'] = 0;
        $accounts = [];

        foreach ($info as $key => $value) {
            $accounts[] = $value['balance_name'];
        }
        natcasesort($accounts);
        
        $result['numberAccounts'] = count(array_unique($accounts));
        $accounts = array_count_values($accounts);        
        //$result['accounts'] = $accounts;
        $accountini = [];

        foreach ($accounts as $key => $value) {
            $accountini[] = $key . ' (' . $value . ')';
        }
        $result['accounts'] = $accountini;
        //dd($result['accounts']);

        // Companies
        $result['numberCompanies'] = 0;
        $companies = [];

        foreach ($info as $key => $value) {
            $companies[] = $value['company'];
        }
        natcasesort($companies);
        //dd($companies);
        $result['numberCompanies'] = count(array_unique($companies));
        $companies = array_count_values($companies);
        $companini = [];

        foreach ($companies as $key => $value) {
            $companini[] = $key . ' (' . $value . ')';
        }
        $result['companies'] = $companini;

        // Categories
        $result['numberCategories'] = 0;
        $categories = [];

        foreach ($info as $key => $value) {
            $categories[] = $value['category_name'];
        }
        natcasesort($categories);

        $result['numberCategories'] = count(array_unique($categories));
        //$result['categories'] = json_encode(array_count_values($categories));
        $categories = array_count_values($categories);
        $categorini = [];

        foreach ($categories as $key => $value) {
            $categorini[] = $key . ' (' . $value . ')';
        }
        $result['categories'] = $categorini;

        //dd($result);
        return $result;
       

    }

}