<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'name', 'link', 'thumb_slider', 'creator', 'sort', 'status'
    ];

    public function Users()
    {
        return $this->belongsTo('App\User', 'creator');
    }
}
