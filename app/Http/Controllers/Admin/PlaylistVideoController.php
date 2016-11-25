<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Constants;
use App\Playlist;
use App\PlaylistVideo;
use App\User;
use App\Video;
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
        $playlists_videos = $this->getData();
        return view('admin/playlists_videos/index')->with('playlists_videos', $playlists_videos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $videos = Video::all();
        $playlists = $this->getPlaylists();
        return view('admin/playlists_videos/create')
            ->with('videos', $videos)
            ->with('playlists', $playlists);
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
            'playlist_id' => 'required|integer|exists:playlists,id',
            'video_id' => 'required|integer|exists:videos,id',
        ]);
        $user = User::find(Auth::user()->id);
        $playlist = $this->getPlaylists((int)$request->input('playlist_id'));
        if ($user->role === Constants::PARENT_ROLE && $playlist->user_id !== $user->id)
            throw new AuthorizationException();
        PlaylistVideo::create($request->all());
        return redirect(route('admin.playlists_videos.index'));
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
        $playlist = $this->getPlaylists($playlist_video->playlist_id);
        if ($this->isAllowed($playlist, true)) 
            return view('admin/playlists_videos/show')
                ->with('playlist_video', $playlist_video);
        throw new AuthorizationException();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $playlist_video = $this->getData($id);
        $playlist = $this->getPlaylists($playlist_video->playlist_id);
        $videos = Video::All();
        $playlists = $this->getPlaylists();
        if ($this->isAllowed($playlist))
            return view('admin/playlists_videos/edit')
                ->with('playlist_video', $playlist_video)
                ->with('videos', $videos)
                ->with('playlists', $playlists);
        throw new AuthorizationException();
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
            'playlist_id' => 'required|integer|exists:playlists,id',
            'video_id' => 'required|integer|exists:videos,id',
        ]);
        $playlist_video = PlaylistVideo::find($id);
        $playlist = $this->getPlaylists($playlist_video->playlist_id);
        if (!$this->isAllowed($playlist)) throw new AuthorizationException();
        $playlist_video->update($request->all());
        return redirect(route('admin.playlists_videos.index'));
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
            $playlist_video = PlaylistVideo::find($id);
            $playlist = $this->getPlaylists($playlist_video->playlist_id);
            if (!$this->isAllowed($playlist)) return response()->json(Lang::get('main.permissions'), 401);
            $playlist_video->delete();
          return response()->json(Lang::get('main.deleteSuccess'), 200);
        } catch(\Exception $e) {
          return response()->json(Lang::get('main.deleteFail'), 404);
        }
    }

    public function getData($id = null)
    {
        $sql = 'select playlist_video.id,
                playlists.description as playlist,
                playlists.id as playlist_id,
                videos.description as video,
                videos.id as video_id
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

    private function getPlaylists($id = null)
    {
        $sql = 'select playlists.id,
                playlists.description,
                case when playlists.public = \'Y\' then \'Público\' else \'Privado\' end as public,
                playlists.public as public_value,
                users.name as user,
                users.id as user_id
            FROM playlists
                join users on users.id = playlists.user_id';
        $userRole = User::find(Auth::user()->id)->role;
        if ($id !== null) {
            $sql.=' where playlists.id = :playlist';
            $playlists = DB::select($sql, ['playlist' => $id])[0];
        } else if ($userRole === Constants::PARENT_ROLE) {
            $sql.=' where playlists.user_id = :user_id';
            $playlists = DB::select($sql, ['user_id' => Auth::user()->id]);
        } else if ($userRole === Constants::ADMIN_ROLE) $playlists = DB::select($sql);
        return $playlists;
    }

    private function isAllowed($playlist, $readOnly = false)
    {
        if ($readOnly && $playlist->public_value === 'Y') return true;
        $user = User::find(Auth::user()->id);
        if ($user->role === Constants::PARENT_ROLE && $playlist->user_id !== $user->id) {
            return false;
        }
        return true;
    }

}
