<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Constants;
use App\Child;
use App\ChildrenPlaylist;
use App\Playlist;
use App\User;
use Auth;
use DB;
use Lang;

class ChildrenPlaylistController extends Controller implements IController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $data = $this->getData();
        return view('admin/children_playlist/index')->with('data', $data);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $children = $this->getChildren();
        $playlists = $this->getPlaylists();
        return view('admin/children_playlist/create')
            ->with('children', $children)
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
            'children_id' => 'required|integer|exists:children,id',
            'playlist_id' => 'required|integer|exists:playlists,id',
        ]);
        $user = User::find(Auth::user()->id);
        $playlist = Playlist::find((int)$request->input('playlist_id'));
        $child = Child::find((int)$request->input('children_id'));
        if ($playlist->user_id !== $user->id || $child->user_id !== $user->id) {
            if ($playlist->public !== 'Y') {
                throw new AuthorizationException();
            }
        }
        ChildrenPlaylist::create($request->all());
        return redirect(route('admin.children_playlist.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->getData($id);
        if ($this->isAllowed($data))
            return view('admin/children_playlist/show')->with('data', $data);
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
        $data = $this->getData($id);
        $children = $this->getChildren();
        $playlists = $this->getPlaylists();
        if (!$this->isAllowed($data)) throw new AuthorizationException();
        return view('admin/children_playlist/edit')
            ->with('data', $data)
            ->with('children', $children)
            ->with('playlists', $playlists);
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
            'children_id' => 'required|integer|exists:children,id',
            'playlist_id' => 'required|integer|exists:playlists,id',
        ]);
        $user = User::find(Auth::user()->id);
        $playlist = Playlist::find((int)$request->input('playlist_id'));
        $child = Child::find((int)$request->input('children_id'));
        if ($playlist->user_id !== $user->id || $child->user_id !== $user->id) {
                if ($playlist->public !== 'Y') {
                throw new AuthorizationException();
            }
        }
        $item = ChildrenPlaylist::find($id);
        $item->update($request->all());
        return redirect(route('admin.children_playlist.index'));
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
            $item = ChildrenPlaylist::find($id);
            if (!$this->isAllowed($item)) return response()->json(Lang::get('main.permissions'), 401);
            $item->delete();
            return response()->json(Lang::get('main.deleteSuccess'), 200);
        } catch(\Exception $e) {
            return response()->json(Lang::get('main.deleteFail'), 404);
        }
    }

    public function getData($id = null)
    {
        $sql = 'select children_playlist.id,
                playlists.description,
                playlists.id as playlist_id,
                children.username,
                children.id as children_id
            from children_playlist
            join playlists on playlists.id = children_playlist.playlist_id
            join children on children.id = children_playlist.children_id';
        $userRole = User::find(Auth::user()->id)->role;
        if ($id !== null) {
          $sql.=' where children_playlist.id = :id';
          $data = DB::select($sql, ['id' => $id])[0];
        } else if ($userRole === Constants::PARENT_ROLE) {
            $sql.=' where playlists.user_id = ? and children.user_id = ?';
            $data = DB::select($sql, [Auth::user()->id, Auth::user()->id]);
        } else if ($userRole === Constants::ADMIN_ROLE) $data = DB::select($sql);
        return $data;
    }

    private function getChildren()
    {
        $sql = 'select id,
                username
            from children';
        $userRole = User::find(Auth::user()->id)->role;
        if ($userRole === Constants::PARENT_ROLE) {
            $sql.=' where user_id = :user_id';
            $data = DB::select($sql, ['user_id' => Auth::user()->id]);
        } else if ($userRole === Constants::ADMIN_ROLE) $data = DB::select($sql);
        return $data;
    }

    private function getPlaylists()
    {
        $sql = 'select id,
                description
            from playlists';
        $userRole = User::find(Auth::user()->id)->role;
        if ($userRole === Constants::PARENT_ROLE) {
            $sql.=' where user_id = :user_id';
            $data = DB::select($sql, ['user_id' => Auth::user()->id]);
        } else if ($userRole === Constants::ADMIN_ROLE) $data = DB::select($sql);
        return $data;
    }

    private function isAllowed($children_playlist)
    {
        $playlist = Playlist::find($children_playlist->playlist_id);
        $child = Child::find($children_playlist->children_id);
        $user = User::find(Auth::user()->id);
        if ($user->role === Constants::ADMIN_ROLE) return true;
        if ($playlist->user_id !== $user->id || $child->user_id !== $user->id) {
            return false;
        }
        return true;
    }
}
