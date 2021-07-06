<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Repository\OrderRepository;
use App\Order;
use \Cart;
use Auth;

class ShoppingController extends Controller
{
    protected $response;

    protected $order;

    public function __construct(ResponseFactory $response, OrderRepository $order)
    {
        $this->middleware('auth:admin');
        $this->middleware('customer');

        $this->response = $response;
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::getContent();
        $total = Cart::getTotal();
        return $this->response->view('cart.checkout', [
            'cartItem' => $cart,
            'total'=> $total,
            'cartCount'=>$cart->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'user_id'=>auth()->user()->id,
            'orders'=>Cart::getContent(),
            'total'=>Cart::getTotal(),
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'email'=>$request->email,
            'address'=>$request->address
        ];

        $this->order->store($data);
        Cart::clear();
        return $this->response->redirectToRoute('checkout.index')->with('message','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
