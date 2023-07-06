<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name', 'slug', 'code', 'status', 'creator'
    ];

    public function products()
    {
        return $this->belongsToMany('App/Product', 'product_color');
    }
    public function Users()
    {
        return $this->belongsTo('App\User', 'creator');
    }
}
