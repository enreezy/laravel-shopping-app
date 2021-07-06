<?php

namespace App\Http\Controllers;

use App\AdminImage;
use Illuminate\Routing\ResponseFactory;
use App\Repository\AdminImageRepository;
use Illuminate\Http\Request;

class AdminImageController extends Controller
{
    protected $response;

    protected $admin;

    public function __construct(AdminImageRepository $admin, ResponseFactory $response)
    {
        $this->response = $response;
        $this->admin = $admin;

        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = $this->admin->paginate(20);
        return $this->response->view('admin.images.index', ['images'=>$images]);
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
        $image = $request->file('img_src');
        $img_url = $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $file = $request->file('img_src')->storeAs('storage/images', $img_url, 'public');

        $sender_id = $request->sender_id;

        $data = [
            'img_src' => $img_url,
            'sender_id' => $sender_id
        ];

        $this->admin->store($data);

        return redirect()->back()->with('message', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AdminImage  $adminImage
     * @return \Illuminate\Http\Response
     */
    public function show(AdminImage $adminImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdminImage  $adminImage
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminImage $adminImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdminImage  $adminImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminImage $adminImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdminImage  $adminImage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adminImage = $this->admin->findOrFail($id);
        $this->admin->delete($adminImage);

        return redirect()->back()->with('message','deleted');
    }
}
