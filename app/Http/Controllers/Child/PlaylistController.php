<?php

namespace App\Http\Controllers\Child;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use DB;
use Lang;

class PlaylistController extends Controller implements IController
{
    public function __construct()
    {
        $this->middleware('auth:child');
    }

    public function index(Request $request)
    {
        return response()->json($this->filterData($request->input('search')), 200);
    }

    public function filterData($search)
    {
        $sql = 'select distinct(playlists.id),
                playlists.description as playlist,
                videos.description as video
            from playlists
                join playlist_video on playlist_video.playlist_id = playlists.id
                join videos on videos.id = playlist_video.video_id
                join categories on categories.id = videos.category_id
                and categories.minimum_age <= :age';
        if (isset($search)) {
            $sql.=' where playlists.description like \'%:search%\'';
            $sql = str_replace(':search', $search, $sql);
        }
        $playlists = DB::select($sql, ['age' => $this->getYears()]);
        return $playlists;
    }

    private function getYears()
    {
        $sql = 'select date_format(now(), \'%Y\') - date_format(?, \'%Y\')
                - (date_format(now(), \'00-%m-%d\') < date_format(?, \'00-%m-%d\'))
                as age from children where id = ?';
        $user = Auth::guard('child')->user();
        $data = DB::select($sql, [$user->birthdate, $user->birthdate, 1])[0];
        return (int)$data->age;
    }
}
