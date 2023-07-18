<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'code', 'desc_quick', 'desc_detail', 'thumb_main',   'thumb_detail', 'creator', 'amount', 'old_price', 'discount', 'new_price', 'cat_id', 'featured_products', 'status', 'slug'
    ];

    public function colors()
    {
        return $this->belongsToMany('App\Color', 'product_color');
    }

    public function configs()
    {
        return $this->belongsToMany('App\Config', 'product_config')->withPivot('price');
        //->withTimestamps()
    }

    public function Cat_product()
    {
        return $this->belongsTo('App\Cat_product', 'cat_id');
    }
    public function Users()
    {
        return $this->belongsTo('App\User', 'creator');
    }
}
