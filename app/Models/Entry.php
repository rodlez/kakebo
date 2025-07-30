<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'title',
        'company',
        'value',
        'frequency',
        'date',        
        'info'
    ];

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

    /**
     * Get the category associated with the Entry.
     */
    public function category()
    {
        return $this->belongsTo(
            Category::class,
            foreignKey: 'category_id'
        );
    }

    /**
     * Get the tags associated with the Sport.
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            table: 'entry_tag',
            foreignPivotKey: 'entry_id'
        )->withTimestamps();
    }

    /**
     * Get the Files associated.
     */
    public function files()
    {
        return $this->hasMany(
            File::class,
            foreignKey: 'entry_id'
        );
    }

}
