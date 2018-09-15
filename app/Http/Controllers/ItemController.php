<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Repository\ItemRepository;
use App\Repository\CategoryRepository;
use Illuminate\Routing\ResponseFactory;
use Cart;

class ItemController extends Controller
{
    protected $item;

    protected $response;

    public function __construct(ItemRepository $item, ResponseFactory $response)
    {
        $this->middleware('auth:admin');
        $this->middleware('admin');
        $this->item = $item;
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

        return $this->response->view('admin.item.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRepository $category)
    {
        return $this->response->view('admin.item.create', [
            'categories'=>$category->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {   
        
        $image = $request->file('img_src');
        $img_url = $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $file = $request->file('img_src')->storeAs('storage/images', $img_url, 'public');
        $attributes = ['size'=>$request->size, 'color'=>$request->color];

        $data = [
            'name'=>$request->name,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'img_src'=>$img_url,
            'attributes'=>$attributes,
            'category'=>$request->category,
            'description'=>$request->description
        ];

        $this->item->store($data);

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $this->response->view('admin.item.show', ['item'=>$item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return $this->response->view('admin.item.edit', ['item'=>$item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if($request->img_src == null)
        {
            $img_src = $item->img_src;
        }else{
            $img_src = $request->img_src;
        }

        $data = [
            'name'=>$request->name,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'img_src'=>$img_src,
            'attributes'=>"['size'=>$request->size, 'color'=>$request->color]",
            'category'=>$request->category,
            'description'=>$request->description
        ];

        $this->item->update($item, $data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $this->item->delete($item);
        return redirect()->back();
    }
}
