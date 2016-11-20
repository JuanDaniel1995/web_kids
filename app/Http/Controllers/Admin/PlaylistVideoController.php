<?php

namespace App\Http\Controllers;

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
        //
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

}
