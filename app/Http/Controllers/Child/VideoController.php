<?php

namespace App\Http\Controllers\Child;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Video;
use Auth;
use DB;

class VideoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $videos = Video::all();
        if ($request->wantsJson())
            return response()->json($this->filterData($request->input('search')), 200);
        return view('child/test')->with('videos', $videos);
    }

    private function filterData($search)
    {
        $sql = 'select videos.id,
                videos.description,
                videos.url,
                categories.name as category
            from videos
                join categories
                on categories.id = videos.category_id
            where videos.description like \'%:search%\'
            or categories.name like \'%:search%\'';
        $sql = str_replace(':search', $search, $sql);
        $videos = DB::select($sql);
        return $videos;
    }
}
