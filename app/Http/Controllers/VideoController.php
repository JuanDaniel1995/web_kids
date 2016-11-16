<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Video;
use Auth;
use DB;
use Lang;

class VideoController extends Controller implements IController
{
   
    public function __construct()
    {
        $this->middleware('is_admin')->except('index');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = $this->getData();
        return view('videos/index')->with('videos', $videos);;
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
        $video = $this->getData($id);
        return view('videos/show')->with('video', $video);
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

    public function getData($id = null)
    {
        $sql = 'select videos.id,
            videos.description,
            videos.url,
            categories.name as category
            from videos
                inner join categories
                on categories.id = videos.category_id';
        if ($id !== null) {
          $sql.=' where videos.id = :video_id';
          $videos = DB::select($sql, ['video_id' => $id])[0];
        } else $videos = DB::select($sql);
        return $videos;
    }
}
