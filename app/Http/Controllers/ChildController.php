<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Constants;
use App\Child;
use App\User;
use Auth;
use DB;
use Lang;

class ChildController extends Controller implements IController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $children = $this->getData();
        return view('children/index')->with('children', $children);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('children/create');
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
            'username' => 'required|max:255|unique:children',
            'birthdate' => ['required', 'regex:/^((19|20)[\d]{2})[\-\/](0?[1-9]|1[012])[\-\/](0?[1-9]|[12][\d]|3[01])$/', 'date'],
            'password' => 'required|confirmed',
            'enabled_search' => ['required', 'regex:/^(E|D)$/'],
            'restricted_mode' => ['required', 'regex:/^(Y|N)$/'],
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $user = User::find(Auth::user()->id);
        if ($user->role === Constants::PARENT_ROLE && (int)$request->input('user_id') !== $user->id) {
            throw new AuthorizationException();
        }
        Child::create($request->all());
        return redirect(route('children.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $child = $this->getData($id);
        if ($this->isAllowed($child)) return view('children/show')->with('child', $child);
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
        $child = $this->getData($id);
        if ($this->isAllowed($child)) return view('children/edit')->with('child', $child);
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
            'username' => 'required|max:255',
            'birthdate' => ['required', 'regex:/^((19|20)[\d]{2})[\-\/](0?[1-9]|1[012])[\-\/](0?[1-9]|[12][\d]|3[01])$/', 'date'],
            'enabled_search' => ['required', 'regex:/^(E|D)$/'],
            'restricted_mode' => ['required', 'regex:/^(Y|N)$/'],
            'user_id' => 'required|integer',
        ]);
        $child = Child::find($id);
        if (!$this->isAllowed($child)) throw new AuthorizationException();
        $child->update($request->all());
        return redirect(route('children.index'));
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
            $child = Child::find($id);
            if (!$this->isAllowed($child)) return response()->json(Lang::get('main.permissions'), 401);
            $child->delete();
            return response()->json(Lang::get('main.deleteSuccess'), 200);
        } catch(\Exception $e) {
            return response()->json(Lang::get('main.deleteFail'), 404);
        }
    }

    public function getData($id = null)
    {
        $sql = 'select id,
                username,
                birthdate,
                user_id,
                case when enabled_search = "E" then "Habilitado" else "Deshabilitado" end as "enabled_search",
                case when restricted_mode = "Y" then "Habilitado" else "Deshabilitado" end as "restricted_mode",
                enabled_search as "search_value",
                restricted_mode as "restricted_value"
                from children';
        $userRole = User::find(Auth::user()->id)->role;
        if ($id !== null) {
          $sql.=' where id = :child_id';
          $children = DB::select($sql, ['child_id' => $id])[0];
        } else if ($userRole === Constants::PARENT_ROLE) {
            /*$sql.=' where user_id = :user_id';
            $children = DB::select($sql, ['user_id' => Auth::user()->id]);*/
            $children = DB::select($sql);
        } else if ($userRole === Constants::ADMIN_ROLE) $children = DB::select($sql);
        return $children;
    }

    private function isAllowed($child)
    {
        $user = User::find(Auth::user()->id);
        if ($user->role === Constants::PARENT_ROLE && $child->user_id !== $user->id) {
            return false;
        }
        return true;
    }
}
