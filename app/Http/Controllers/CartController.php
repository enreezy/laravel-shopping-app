<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ItemRepository;
use Auth;
use Illuminate\Routing\ResponseFactory;
use Cart;
class CartController extends Controller
{
    protected $item;


    protected $response;

    public function __construct(ItemRepository $item,ResponseFactory $response)
    {
        //injected repository
        $this->item = $item;
        //injected response
        $this->response = $response;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items = $this->item->paginate(10);
        $cart = Cart::getContent();
        return $this->response->view('cart.home', [
            'items'=>$items,
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
        Cart::add($request->id, $request->name, $request->price, $request->quantity, [$request->size, $request->color]);
        return $this->response->redirectToRoute('shopping.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $userId = auth()->user()->id; // or any string represents user identifier
        Cart::session($userId)->update($request->id, array(
          'name' => $request->name, // new item name
          'price' => $request->price, // new item price, price can also be a string format like so: '98.67'
          'quantity' => $request->quantity,
          'attributes' => [
            'size' => $request->size,
            'color' => $request->color
          ]
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $userId = auth()->user()->id;
        Cart::session($userId)->remove($request->id);
    }
}
