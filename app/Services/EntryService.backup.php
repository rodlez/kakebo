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


    // test stats, do cases for user and for admin

    public function getTotalStats(mixed $data): array
    {
        //dd($data);

        $stats = [];
        // Users
        $stats['users'] = $data->pluck('user_id')->unique()->count();
        // Incomes & Expenses
        $stats['incomes'] = 0;
        $stats['numberIncomes'] = 0;
        $stats['expenses'] = 0;
        $stats['numberExpenses'] = 0;
        // Dates
        $stats['days'] = $data->pluck('date')->unique()->count();
        $stats['dateFrom'] = $data->min('date');
        $stats['dateTo'] = $data->max('date');
        // Sources
        $stats['sourceCash'] = $data->where('balance_source', '=', 'cash')->count();
        $stats['sourceCard'] = $data->where('balance_source', '=', 'card')->count();
        $stats['sourceStocks'] = $data->where('balance_source', '=', 'stocks')->count();
        // Accounts
        $stats['numberAccounts'] = $data->pluck('balance_name')->unique()->count();         
        $accounts = $data->pluck('balance_name')->unique()->toArray(); 

        foreach ($accounts as $account) {
            $stats['accounts'][$account] = $data->where('balance_name', '=', $account)->count();
        }

        // Companies
        $stats['numberCompanies'] = $data->pluck('company')->unique()->count();
        $companies = $data->pluck('company')->unique()->toArray(); 

        foreach ($companies as $company) {
            $stats['companies'][$company] = $data->where('company', '=', $company)->count();
        }

        // Categories
        $stats['numberCategories'] = $data->pluck('category_name')->unique()->count();
        $categories = $data->pluck('category_name')->unique()->toArray(); 

        foreach ($categories as $category) {
            $stats['categories'][$category] = $data->where('category_name', '=', $category)->count();
        }

        foreach ($data as $entry) 
        {
            // Incomes and Expenses
            if($entry->type == 1)
            {
                $stats['incomes'] = $stats['incomes'] + $entry->value;
                $stats['numberIncomes']++;
            } else
            {
                $stats['expenses'] = $stats['expenses'] + $entry->value;
                $stats['numberExpenses']++;
            }
            
        }
        
        //dd($stats);
        return $stats;
    }

}