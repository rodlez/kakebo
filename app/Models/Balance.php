<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = [    
        'user_id',
        'name',
        'source',
        'total',        
        'date',        
        'info'
    ];

    /**
     * Get the entries associated with the balance.
     */
    public function entries()
    {
        return $this->hasMany(
            Entry::class,
            foreignKey: 'balance_id'
        );
    }

     /**
     * Get the user associated with the Entry.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            foreignKey: 'user_id'
        );
    }

}
