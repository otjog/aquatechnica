<?php

namespace App\Libraries\Services\Pay;

use App\Libraries\Services\Pay\Contracts\OnlinePayment;
use App\Product;
use Illuminate\Http\Request;
use App\ShopBasket;
use App\ShopOrder;

class Paymaster implements OnlinePayment{

    private $shop_id;

    private $secret;

    private $send_url;

    private $hash_parameters;

    public function __construct(){

        $this->shop_id = env('PAYMASTER_SITE_ID');

        $this->secret = env('PAYMASTER_SECRET');

        $this->send_url = env('PAYMASTER_URL');

        $this->hash_parameters = [
            'LMI_MERCHANT_ID',
            'LMI_PAYMENT_NO',
            'LMI_SYS_PAYMENT_ID',
            'LMI_SYS_PAYMENT_DATE',
            'LMI_PAYMENT_AMOUNT',
            'LMI_CURRENCY',
            'LMI_PAID_AMOUNT',
            'LMI_PAID_CURRENCY',
            'LMI_PAYMENT_SYSTEM',
            'LMI_SIM_MODE',
        ];
    }

    public function send(Request $request){

        $query = $this->getQuery($request->all());

        return redirect()->away($this->send_url.$query);
    }

    public function confirm(Request $request, ShopBasket $baskets, Product $products){

        $request_shop_id = $request['LMI_MERCHANT_ID'];

        $total_payment = (float)$request['LMI_PAYMENT_AMOUNT'];

        $token = $request['_token'];

        $basket = $baskets->getActiveBasketWithProducts( $products, $token );

        if($request_shop_id === $this->shop_id){

            if($total_payment === $basket->total){

                return 'YES';

            }

        }

        return 'NO';

    }

    public function execute(Request $request, ShopOrder $orders, ShopBasket $baskets){

        $receipt_number = $request['LMI_SYS_PAYMENT_ID'];

        $request_hash = $request['LMI_HASH'];

        $token = $request['_token'];

        $paidOrder = $orders->getOrderByPayId( $receipt_number );

        if($paidOrder === null){

            $activeBasket = $baskets->getActiveBasket( $token );

            $my_hash = $this->getOurHash($request->all(), $activeBasket);

            if($my_hash === $request_hash){
                $add = [
                    'paid' => 1,
                    'pay_id' => $receipt_number,
                ];
            }else{
                $add = [
                    'paid' => -1,
                    'pay_id' => $receipt_number,
                ];
            }

            $data = array_merge($add, $request->all());

            $orders->storeOrder($data, $activeBasket);
        }

    }

    public function redirect(Request $request, ShopOrder $orders, $msg){

        $receipt_number = $request['LMI_SYS_PAYMENT_ID'];

        $order = $orders->getOrderByPayId( $receipt_number );

        switch($msg){
            case 'success'  : return redirect('orders/'.$order[0]->id)->with('status', 'Заказ оформлен! Скоро с вами свяжется наш менеджер');
        }

        return redirect('orders/create')->with('status', 'Ошибка');

        //todo сделать разные сообщения об ошибках
    }

    //Helpers
    private function getQuery($parameters){
        $query = '?';

        foreach($parameters as $key => $value){

            if($query !== '?'){
                $query .= '&';
            }

            $query .= $key . '=' . urlencode($value);

        }

        return $query;
    }

    private function getOurHash($request, $activeBasket){

        $strForHash = '';

        foreach($this->hash_parameters as $key => $parameter){

            if( isset( $request[ $parameter ] ) ){

                switch($parameter){
                    case 'LMI_MERCHANT_ID'  : $strForHash .= $this->shop_id; break;
                    case 'qLMI_PAYMENT_NO'   : $strForHash .= $activeBasket->id; break; //тут пока всегда приходит 123
                    default : $strForHash .= $request[ $parameter ];
                }

            }

            $strForHash .= ';';

        }

        $strForHash .= $this->secret;

        return base64_encode(md5($strForHash, true));
    }

}