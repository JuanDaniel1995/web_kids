<?php

namespace App\Http\Controllers\Child;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use DB;
use Lang;

class VideoController extends Controller implements IController
{

    public function __construct()
    {
        $this->middleware('auth:child');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('child')->user()->enabled_search === 'D')
            return response()->json(Lang::get('main.permissions'), 401);
        return response()->json($this->filterData($request->input('search')), 200);
    }

    public function filterData($search)
    {
        $sql = 'select distinct(videos.id),
                videos.description,
                videos.url
            from videos
                join categories on categories.id = videos.category_id
                and categories.minimum_age <= :age';
        if (isset($search)) {
            $sql.=' join tag_video on tag_video.video_id = videos.id
                    join tags on tags.id = tag_video.tag_id
                    where videos.description like \'%:search%\'
                    or tags.description like \'%:search%\'';
            $sql = str_replace(':search', $search, $sql);
        }
        $videos = DB::select($sql, ['age' => $this->getYears()]);
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
