<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $table = 'shop_customer_groups';

    public function customers()
    {
        return $this->hasMany('App\Models\Shop\Customer');
    }

    public function price()
    {
        return $this->belongsTo(    'App\Models\Shop\Price\Price');
    }
}
