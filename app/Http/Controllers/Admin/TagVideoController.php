<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Tag;
use App\TagVideo;
use App\Video;
use DB;
use Lang;

class TagVideoController extends Controller implements IController
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
        $tags_videos = $this->getData();
        return view('admin/tags_videos/index')->with('tags_videos', $tags_videos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $videos = Video::All();
        $tags = Tag::all();
        return view('admin/tags_videos/create')
            ->with('videos', $videos)
            ->with('tags', $tags);
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
            'tag_id' => 'required|integer|exists:tags,id',
            'video_id' => 'required|integer|exists:videos,id',
        ]);
        TagVideo::create($request->all());
        return redirect(route('admin.tags_videos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag_video = $this->getData($id);
        return view('admin/tags_videos/show')
            ->with('tag_video', $tag_video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $videos = Video::All();
        $tags = Tag::all();
        $tag_video = $this->getData($id);
        return view('admin/tags_videos/edit')
            ->with('tag_video', $tag_video)
            ->with('videos', $videos)
            ->with('tags', $tags);
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
            'tag_id' => 'required|integer|exists:tags,id',
            'video_id' => 'required|integer|exists:videos,id',
        ]);
        $tag_video = TagVideo::find($id);
        $tag_video->update($request->all());
        return redirect(route('admin.tags_videos.index'));
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
          TagVideo::destroy($id);
          return response()->json(Lang::get('main.deleteSuccess'), 200);
        } catch(\Exception $e) {
          return response()->json(Lang::get('main.deleteFail'), 404);
        }
    }

    public function getData($id = null)
    {
        $sql = 'select tag_video.id,
                tags.description as tag,
                tags.id as tag_id,
                videos.description as video,
                videos.id as video_id
            from tag_video
                join tags on tags.id = tag_video.tag_id
                join videos on videos.id = tag_video.video_id';
        if ($id !== null) {
          $sql.=' where tag_video.id = :tag_video';
          $tag_video = DB::select($sql, ['tag_video' => $id])[0];
        } else $tag_video = DB::select($sql);
        return $tag_video;
    }
}
