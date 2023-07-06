<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name', 'slug', 'title', 'content', 'status', 'creator'
    ];
    public function Users()
    {
        return $this->belongsTo('App\User', 'creator');
    }
}
