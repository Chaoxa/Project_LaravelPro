<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'name', 'link', 'thumb_banner', 'creator', 'sort', 'status'
    ];
    public function Users()
    {
        return $this->belongsTo('App\User', 'creator');
    }
}
