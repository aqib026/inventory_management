<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = \App\Permission::orderBy('id','desc')->paginate(50);
        return view('permissions.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new \App\Permission;
        return view('permissions.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validate($request, [
            'name' => 'required|unique:permissions|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required|max:255',           
        ]);

        $r = new \App\Permission;
        $r->name = $request->get('name');
        $r->display_name = $request->get('display_name');
        $r->description = $request->get('description');
        $r->save();
        return redirect('/permissions')->with('success','Permission Has Been Created');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = \App\Permission::find($id);
        return view('permissions.edit',compact('model'));
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
        $validation = $this->validate($request, [
            'name' => 'required|unique:permissions,id|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required|max:255',           
        ]);
        $r = \App\Permission::find($id);
        $r->name = $request->get('name');
        $r->display_name = $request->get('display_name');
        $r->description = $request->get('description');
        $r->save();
        return redirect('/permissions')->with('success','Permission Has Been Updated');
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
}
