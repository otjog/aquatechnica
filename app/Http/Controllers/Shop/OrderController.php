<?php

namespace App\Http\Controllers\Shop;

use App\Events\NewOrder;
use App\Libraries\Services\Pay\Contracts\OnlinePayment;
use App\Models\Shop\Customer;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShopBasket;
use App\ShopOrder;
use App\Product;

class OrderController extends Controller{

    protected $orders;

    protected $baskets;

    protected $data;

    public function __construct(ShopOrder $orders, ShopBasket $baskets){
        $this->orders   = $orders;
        $this->baskets  = $baskets;
        $this->data = [
            'template'  =>  [
                'component' => 'shop',
                'resource'  => 'order',
            ],
            'data'      => [
                'chunk' => 3
            ]
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //GET
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Payment $payments, OnlinePayment $paymentService, Customer $customers){

        $payment = $payments->getMethodById($request->payment_id);

        if($payment[0]->alias === 'online'){

            return $paymentService->send($request);

        }else{

            $token = $request['_token'];

            $customer = $customers->findOrCreateCustomer( $request->all() );

            $basket = $this->baskets->getActiveBasket( $token );

            $order = $this->orders->storeOrder( $request->all(), $basket, $customer );

            event(new NewOrder($order));

            return redirect('orders/'.$order->id)->with('status', 'Заказ оформлен! Скоро с вами свяжется наш менеджер');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Product $products, Payment $payments){

        $token = $request->session()->get('_token');

        $this->data['template']['view'] = 'create';

        $this->data['data']['basket']   = $this->baskets->getActiveBasketWithProducts( $products, $token );

        $this->data['data']['payments'] = $payments->getActiveMethods();

        return view( 'templates.default', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $products, $id){

        $this->data['template']['view'] = 'show';

        $this->data['data']['order']    = $this->orders->getOrderById($products, $id);

        return view( 'templates.default', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //GET
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //PUT/PATCH
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //DELETE
    }

    /*****************Helpers**********************/
}
