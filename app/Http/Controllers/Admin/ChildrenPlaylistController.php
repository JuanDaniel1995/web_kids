<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Constants;
use App\Category;
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
        return view('admin/children_playlist/create');
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
        Child::create($request->all());
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
        $sql = 'select children_playlist.id,
                playlists.description,
                children.username
            from children_playlist
            join playlists on playlists.id = children_playlist.playlist_id
            join children on children.id = children_playlist.children_id';
        $userRole = User::find(Auth::user()->id)->role;
        if ($id !== null) {
          $sql.=' where children_playlist.id = :id';
          $data = DB::select($sql, ['playlist' => $id])[0];
        } else if ($userRole === Constants::PARENT_ROLE) {
            $sql.=' where playlists.user_id = :user_id';
            $data = DB::select($sql, ['user_id' => Auth::user()->id]);
        } else if ($userRole === Constants::ADMIN_ROLE) $data = DB::select($sql);
        return $data;
    }
}
