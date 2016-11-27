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
        $user = Auth::guard('child')->user();
        $sql = 'select videos.description,
                videos.url
            from videos
                join playlist_video on playlist_video.video_id = videos.id
                join playlists on playlists.id = playlist_video.playlist_id
                join categories on categories.id = videos.category_id';
        if ($user->restricted_mode === 'Y')
            $sql.= ' and categories.minimum_age <= :age';
        if (isset($search)) {
            $sql.=' where playlists.description like \'%:search%\'';
            $sql = str_replace(':search', $search, $sql);
        }
        if ($user->restricted_mode === 'Y')
            $videos = DB::select($sql, ['age' => $this->getYears()]);
        else
            $videos = DB::select($sql);
        return $videos;
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
