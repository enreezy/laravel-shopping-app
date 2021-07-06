<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ItemRepository;
use App\Repository\CategoryRepository;
use Auth;
use Illuminate\Routing\ResponseFactory;
use Cart;
class CartController extends Controller
{
    protected $item;

    protected $category;

    protected $response;

    public function __construct(ItemRepository $item,ResponseFactory $response,CategoryRepository $category)
    {
        $this->middleware('auth:admin');
        $this->middleware('customer');
        //injected repository
        $this->item = $item;
        //injected response
        $this->response = $response;

        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->item->paginate(10);
        $category = $this->category->all();
        $cart = Cart::getContent();
        return $this->response->view('cart.home', [
            'items'=>$items,
            'cartCount'=>$cart->count(),
            'category'=>$category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cart::add($request->id, $request->name, $request->price, 1, ['size'=>$request->size, 'color'=>$request->color,'max'=>$request->quantity]);
        return back()->with(['added'=>'added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = Cart::getContent();
        $item = $this->item->findOrFail($id);
        return $this->response->view('cart.product', [
            'item'=>$item,
            'cartCount'=>$cart->count()
        ]);
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
        Cart::update($request->id, array(
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
        Cart::remove($id);
        return redirect()->back();
    }

    public function empty()
    {
        Cart::empty();
        return redirect()->back();
    }
}
