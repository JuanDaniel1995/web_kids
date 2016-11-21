<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Constants;
use App\Playlist;
use App\User;
use Auth;
use DB;
use Lang;

class PlaylistVideoController extends Controller implements IController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $playlists = $this->getData();
        return view('admin/playlists_videos/index')->with('playlists', $playlists);
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
        $playlist_video = $this->getData($id);
        return view('admin/playlists_videos/show')->with('playlist_video', $playlist_video);
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
        $sql = 'select playlist_video.id,
                playlists.description as playlist,
                videos.description as video
            from playlist_video
                join playlists on playlists.id = playlist_video.playlist_id
                join videos on videos.id = playlist_video.video_id';
        $userRole = User::find(Auth::user()->id)->role;
        if ($id !== null) {
          $sql.=' where playlist_video.id = :playlist_video';
          $list_video = DB::select($sql, ['playlist_video' => $id])[0];
        } else if ($userRole === Constants::PARENT_ROLE) {
            $sql.=' where playlists.user_id = :user_id or playlists.public = \'Y\'';
            $list_video = DB::select($sql, ['user_id' => Auth::user()->id]);
        } else if ($userRole === Constants::ADMIN_ROLE) $list_video = DB::select($sql);
        return $list_video;
    }

}
