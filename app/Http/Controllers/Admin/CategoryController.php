<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Constants;
use App\Category;
use Auth;
use DB;
use Lang;

class CategoryController extends Controller implements IController
{

    public function __construct()
    {
        $this->middleware('is_admin')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->getData();
        return view('admin/categories/index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/categories/create');
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
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'required|max:255|string',
            'minimum_age' => 'required|integer|between:1,100',
        ]);
        Category::create($request->all());
        return redirect(route('admin.categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->getData($id);
        return view('admin/categories/show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->getData($id);
        return view('admin/categories/edit')->with('category', $category);
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
            'name' => 'required|string|max:255',
            'description' => 'required|max:255|string',
            'minimum_age' => 'required|integer|between:1,100',
        ]);
        $category = Category::find($id);
        $category->update($request->all());
        return redirect(route('admin.categories.index'));
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
          Category::destroy($id);
          return response()->json(Lang::get('main.deleteSuccess'), 200);
        } catch(\Exception $e) {
          return response()->json(Lang::get('main.deleteFail'), 404);
        }
    }

    public function getData($id = null)
    {
        $sql = 'select id,
                name,
                description,
                minimum_age
                from categories';
        if ($id !== null) {
          $sql.=' where id = :category_id';
          $categories = DB::select($sql, ['category_id' => $id])[0];
        } else $categories = DB::select($sql);
        return $categories;
    }
}
