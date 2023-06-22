<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_product extends Model
{
    protected $fillable = [
        'name', 'slug', 'parent_id', 'creator', 'status'
    ];
}
