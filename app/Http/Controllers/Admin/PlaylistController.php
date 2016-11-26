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


class PlaylistController extends Controller implements IController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlists = $this->getData();
        return view('admin/playlists/index')->with('playlists', $playlists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/playlists/create');
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
            'description' => 'required|max:255|string|unique:playlists',
            'user_id' => 'required|integer|exists:users,id',
            'public' => ['required', 'regex:/^(Y|N)$/'],
        ]);
        $user = User::find(Auth::user()->id);
        if ($user->role === Constants::PARENT_ROLE && (int)$request->input('user_id') !== $user->id) {
            throw new AuthorizationException();
        }
        Playlist::create($request->all());
        return redirect(route('admin.playlists.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $playlist = $this->getData($id);
        if ($this->isAllowed($playlist, true)) return view('admin/playlists/show')->with('playlist', $playlist);
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
        $playlist = $this->getData($id);
        if ($this->isAllowed($playlist)) return view('admin/playlists/edit')->with('playlist', $playlist);
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
        $playlist = Playlist::find($id);
        if ($request->ajax()) {
            $user = User::find(Auth::user()->id);
            if ($user->role === Constants::PARENT_ROLE && $playlist->user_id !== $user->id) {
                return response()->json(Lang::get('main.permissions'), 401);
            }
            $playlist->update($request->all());
            return response()->json(Lang::get('main.updateSuccess'), 200);
        }
        $this->validate($request, [
            'description' => 'required|max:255|string',
            'public' => ['required', 'regex:/^(Y|N)$/'],
        ]);
        if (!$this->isAllowed($playlist)) throw new AuthorizationException();
        $playlist->update($request->all());
        return redirect(route('admin.playlists.index'));
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
            $playlist = Playlist::find($id);
            if (!$this->isAllowed($playlist)) return response()->json(Lang::get('main.permissions'), 401);
            $playlist->delete();
            return response()->json(Lang::get('main.deleteSuccess'), 200);
        } catch(\Exception $e) {
            return response()->json(Lang::get('main.deleteFail'), 404);
        }
    }

    public function getData($id = null)
    {
        $sql = 'select playlists.id,
                playlists.description,
                case when playlists.public = \'Y\' then \'Público\' else \'Privado\' end as public,
                playlists.public as public_value,
                users.name as user,
                users.id as user_id
            FROM playlists
            inner join users on users.id = playlists.user_id';
        $userRole = User::find(Auth::user()->id)->role;
        if ($id !== null) {
          $sql.=' where playlists.id = :playlist';
          $playlists = DB::select($sql, ['playlist' => $id])[0];
        } else if ($userRole === Constants::PARENT_ROLE) {
            $sql.=' where users.id = :user_id or playlists.public = \'Y\'';
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
