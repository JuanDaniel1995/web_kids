<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Category;
use App\Video;
use Auth;
use DB;
use Lang;

class VideoController extends Controller implements IController
{
   
    public function __construct()
    {
        $this->middleware('is_admin')->except(['index', 'show']);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = $this->getData();
        return view('admin/videos/index')->with('videos', $videos);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin/videos/create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255|string|unique:videos',
            'url' => ['required', 'max:255', 'string', 'regex:/^((https?):\/\/www\.)(([a-z0-9]([-a-z0-9]*[a-z0-9]+)?){1,63}\.)+[a-z]{2,6}/'],
            'category_id' => 'required|integer|exists:categories,id'
        ]);
        Video::create($request->all());
        return redirect(route('admin.videos.index'));
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
        return view('admin/videos/show')->with('video', $video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $video = $this->getData($id);
        return view('admin/videos/edit')->with('video', $video)->with('categories', $categories);
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
        $this->validate($request, [
            'description' => 'required|max:255|string',
            'url' => ['required', 'max:255', 'string', 'regex:/^((https?):\/\/www\.)(([a-z0-9]([-a-z0-9]*[a-z0-9]+)?){1,63}\.)+[a-z]{2,6}/'],
            'category_id' => 'required|integer|exists:categories,id'
        ]);
        $video = Video::find($id);
        $video->update($request->all());
        return redirect(route('admin.videos.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
          Video::destroy($id);
          return response()->json(Lang::get('main.deleteSuccess'), 200);
        } catch(\Exception $e) {
          return response()->json(Lang::get('main.deleteFail'), 404);
        }
    }

    public function getData($id = null)
    {
        $sql = 'select videos.id,
                videos.description,
                videos.url,
                categories.name as category
            from videos
                left join categories
                on categories.id = videos.category_id';
        if ($id !== null) {
          $sql.=' where videos.id = :video_id';
          $videos = DB::select($sql, ['video_id' => $id])[0];
        } else $videos = DB::select($sql);
        return $videos;
    }
}
