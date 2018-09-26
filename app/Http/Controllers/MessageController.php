<?php

namespace App\Http\Controllers;

use Illuminate\Routing\ResponseFactory;
use App\Repository\MessageRepository;
use App\Repository\TopicRepository;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $response;

    protected $message;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ResponseFactory $response, MessageRepository $message, TopicRepository $topic)
    {
        $this->response = $response;
        $this->message = $message;
        $this->topic = $topic;
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
        $topics = $this->topic->all();
        $messages = $this->message->all();
        return $this->response->view('chat.index', ['messages'=>$messages, 'topics'=>$topics]);
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
        $data = ['sender'=>$request->sender, 'receiver'=>$request->receiver, 'message'=>$request->message, 'topic'=>$request->topic];
        $this->message->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
