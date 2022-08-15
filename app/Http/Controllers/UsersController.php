<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $users = \App\User::orderBy('member_id','desc');//
        $search = '';

        if( $request->input('search') ){
            $search = $request->input('search');
            $users = $users->where('username','like','%'.$search.'%');
        }

        $users = $users->paginate(25);        
        return view('users.index',compact('users','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new \App\User;
        $roles  = \App\Role::pluck('name','id');
        return view('users.create',compact('model','roles'));
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
            'username' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
        ]);
        $data = $request->all();
        $user =  \App\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'active' => 0,
            'password' => bcrypt($data['password']),
        ]);    
        $user->attachRole($data['role']);
        return redirect('/users')->with('success','User Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = \App\User::find($id);
        if( isset($model->roles[0]) && $model->roles[0]->name == 'dropshipper'){
            $customers = \App\Customer::where('active',1)->where('type','dropshipper')->pluck('customer_name','customer_id');
        }
        $roles  = \App\Role::pluck('name','id');
        return view('users.edit',compact('model','roles','customers'));
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
            'username' => 'required|unique:users,member_id|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,member_id|max:255',
        ]);
        $data = $request->all();

        $user = \App\User::find($id);
        $user->name     = $data['name'];
        $user->email    = $data['email'];
        $user->username = $data['username'];
        $user->active   = $data['active'];    
        if($data['password'] != ''){
            $user->password   = bcrypt($data['password']);        
        }
        if( isset($data['assign_customer'])){
            $user->assign_customer   = $data['assign_customer'];             
        }
        $user->detachRoles($user->roles);
        $user->attachRole($data['role']);
        $user->save();
        return redirect('/users')->with('success','User Updated Successfully');
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
