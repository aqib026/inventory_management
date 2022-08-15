<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = \App\Role::orderBy('id','desc')->paginate(50);
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new \App\Role;
        return view('roles.create',compact('model'));
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
            'name' => 'required|unique:roles|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required|max:255',           
        ]);

        $r = new \App\Role;
        $r->name = $request->get('name');
        $r->display_name = $request->get('display_name');
        $r->description = $request->get('description');
        $r->save();
        return redirect('/roles')->with('success','Role Has Been Created');
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
        $model = \App\Role::find($id);
        $permissions = \App\Permission::all();
        $assign_perms = array();
        foreach($model->perms as $p){
            $assign_perms[] = $p->id;
        }
        return view('roles.edit',compact('model','permissions','assign_perms'));
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
            'name' => 'required|unique:roles,id|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required|max:255',           
        ]);
        $r = \App\Role::find($id);
        $r->name = $request->get('name');
        $r->display_name = $request->get('display_name');
        $r->description = $request->get('description');
        $r->save();
        \DB::table('permission_role')->where('role_id', $r->id)->delete();

        if( $request->get('permissions') != ''){
            foreach($request->get('permissions') as $pid){
                \DB::table('permission_role')->insert(['permission_id' => $pid, 'role_id' => $r->id]);                            
            }
        }
        return redirect('/roles')->with('success','Role Has Been Updated');

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
