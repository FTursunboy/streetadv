<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{

    /**
     * @param $query
     * @param bool $desc
     * @return Builder
     */
    public function scopeSorted($query, $desc = false)
    {
        return $query->orderBy('sort_number', $desc ? 'desc' : 'asc');
    }


    /**
     * Listen to Model events
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function($instance){
            if (is_null($instance->sort_number)) {
                $instance->sort_number = (int)static::max('sort_number') + 1;
            }
        });
    }

}