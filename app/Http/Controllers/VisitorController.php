<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ItemRepository;
use App\Repository\CategoryRepository;
use Auth;
use Illuminate\Routing\ResponseFactory;
use Cart;

class VisitorController extends Controller
{

    protected $item;

    protected $category;

    public function __construct(ItemRepository $item, ResponseFactory $response, CategoryRepository $category)
    {
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

        //return response()->json($cart);
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
        Cart::add($request->id, $request->name, $request->price, 1, ['size'=>$request->size, 'color'=>$request->color,'max'=>$request->quantity]);
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->item->findOrFail($id);
        $cart = Cart::getContent();
        return $this->response->view('cart.product', [
            'item'=>$item,
            'cartCount'=>$cart->count()
        ]);
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
        Cart::update($id, array(
          'quantity' => array(
              'relative' => false,
              'value' => $request->quantity
          ),
        ));


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return redirect()->back();
    }

    public function checkout()
    {
        $cart = Cart::getContent();
        $total = Cart::getTotal();

        return $this->response->view('cart.checkout', [
            'cartItem' => $cart,
            'total'=> $total,
            'cartCount'=>$cart->count()
        ]);
    }

    public function login()
    {
        return $this->response->view('cart.login');
    }

    public function empty()
    {
        Cart::empty();
        return redirect()->back();
    }
}
