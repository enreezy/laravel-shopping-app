<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Repository\TopicRepository;
use App\Repository\MessageRepository;

class AdminController extends Controller
{
    protected $response;

    protected $message;

    protected $topic;

    public function __construct(ResponseFactory $response, TopicRepository $topic, MessageRepository $message)
    {
        $this->middleware('auth:admin');
        $this->middleware('admin');
        $this->response = $response;
        $this->topic = $topic;
        $this->message = $message;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemDataset = app()->make('Dataset')->getAllItem();
        $quantityDataset = app()->make('Dataset')->getAllItemQuantity();
        $bgcolorDataset = app()->make('Dataset')->getAllItemBGColor();
        return $this->response->view('admin.index', ['itemDataset'=>$itemDataset, 'quantityDataset'=>$quantityDataset, 'bgcolorDataset'=>$bgcolorDataset]);
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
        //
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

    public function topics()
    {
        $topics = $this->topic->paginate(20);
        return $this->response->view('admin.topics.index', ['topics'=>$topics]);
    }

    public function showTopic($id)
    {
        $topic = $this->topic->find($id);
        $messages = $this->message->where(['topic'=>$topic->id]);
        return $this->response->view('admin.chat.index', ['topic'=>$topic, 'messages'=>$messages]);
        //dd($messages);
    }

    public function messages()
    {
        
    }
}
