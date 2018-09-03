<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopBasket extends Model{

    public function shopOrder(){
        return $this->hasOne('App\ShopOrder', 'order_id');
    }

    public function getActiveBasket($token){
        return self::select('id', 'token','products_json', 'order_id')
            ->where('token', $token)
            ->where('order_id', null)
            ->first();
    }

    public function getActiveBasketWithProducts(Product $products, $token){
        $basket = self::select('id', 'token','products_json', 'order_id')
            ->where('token', $token)
            ->where('order_id', null)
            ->get();

        if( count( $basket ) > 0){

            $basket[0]->products = $products->getProductsFromJson($basket[0]->products_json);

            $basket[0]->total = $products->getTotal($basket[0]->products);

            $basket[0]->count_scu = count($basket[0]->products);

            return $basket[0];

        }else{
            return null;
        }

    }

}
