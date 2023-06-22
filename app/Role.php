<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    function permissions()
    {
        return $this->belongsToMany('App\Permission', 'role_permission');
    }
}
