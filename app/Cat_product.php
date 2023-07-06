<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_product extends Model
{
    protected $fillable = [
        'name', 'slug', 'parent_id', 'creator', 'status'
    ];

    public function products()
    {
        return $this->hasMany('App\Product', 'cat_id');
    }
}
