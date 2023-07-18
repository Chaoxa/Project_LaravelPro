<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'content_demo', 'thumb_main', 'cat_parent', 'content', 'status', 'creator'
    ];
    public function Users()
    {
        return $this->belongsTo('App\User', 'creator');
    }
    public function Cat_blog()
    {
        return $this->belongsTo('App\Cat_blog', 'cat_parent');
    }
}
