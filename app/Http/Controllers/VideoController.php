<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Video;
use Auth;
use DB;
use Lang;

use App\Http\Requests;

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
        $videos=$this->getData();
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

    public function getData($id = null)
    {
        $sql = 'select id,
            description,
            url
            from videos';
        if ($id !== null) {
          $sql.=' where id = :video_id';
          $videos = DB::select($sql, ['video_id' => $id])[0];
        } else $videos = DB::select($sql);
        return $videos;
    }
}
