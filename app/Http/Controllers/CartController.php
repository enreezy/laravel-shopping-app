<?php

namespace App\Http\Controllers;

use \Cart;
use Illuminate\Http\Request;
use App\Item;
use App\Repository\ItemRepository;
use Auth;


class CartController extends Controller
{
    protected $item;

    protected $cart;

    public function __construct(Item $item)
    {
        $this->middleware('auth');
        $this->item = new ItemRepository($item);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items = $this->item->paginate(10);
        return view('cart.home', ['items'=>$items]);
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
        $userId = auth()->user()->id;
        Cart::add($request->id, $request->name, $request->price, $request->quantity, [$request->size, $request->color]);

        //return redirect()->route('shopping.index');
        dd(Cart::getContent()); 
        //dd($request); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        return view('cart.checkout');
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
