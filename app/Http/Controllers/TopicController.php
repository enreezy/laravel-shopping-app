<?php

namespace App\Http\Controllers;

use App\Repository\TopicRepository;
use Illuminate\Routing\ResponseFactory;
use App\Repository\MessageRepository;
use Illuminate\Http\Request;
use App\Topic;
use Cart;

class TopicController extends Controller
{
    protected $topic;

    protected $response;

    protected $message;

    public function __construct(TopicRepository $topic, ResponseFactory $response, MessageRepository $message)
    {
        $this->topic = $topic;
        $this->response = $response;
        $this->message = $message;
        $this->middleware('auth:admin');
        $this->middleware('customer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::getContent();
        $topics = $this->topic->paginate(20);
        return $this->response->view('topics.index', ['topics'=>$topics,'cartCount'=>$cart->count()]);
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
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {   
        $cart = Cart::getContent();
        $messages = $this->message->where(['topic'=>$topic->id]);
        return $this->response->view('chat.index', ['topic'=>$topic, 'messages'=>$messages, 'cartCount'=>$cart->count()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        //
    }
}
