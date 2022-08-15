<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = \App\Category::orderBy('cat_id', 'desc')->paginate(50);
        return view('category.index',compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model = new \App\Category;
        $cats  = \App\Category::where('cat_parent',0)->get();

        return view('category.create')->with('model',$model)->with('cats',$cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = $this->validate($request, [
            'cat_name' => 'required|unique:categories|max:255',                  
        ]);
            if($request->get('cat_parent') == '')
                $cat_parent = 0;
            else
                $cat_parent = $request->get('cat_parent');

            $cat = new \App\Category;
            $cat->cat_name     = $request->get('cat_name');
            $cat->cat_desc     = $request->get('cat_desc');
            $cat->cat_keywords = $request->get('cat_keywords');
            $cat->cat_parent   = $cat_parent;
            $cat->save();            
            return redirect('/categories');
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
        $model = \App\Category::find($id);
        $cats  = \App\Category::where('cat_parent',0)->get();
        
        return view('category.update')->with('model',$model)->with('cats',$cats);
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
        $validation = $this->validate($request, [
            'cat_name' => 'required|unique:categories,id|max:255',                  
        ]);
            if($request->get('cat_parent') == '')
                $cat_parent = 0;
            else
                $cat_parent = $request->get('cat_parent');

            $cat = \App\Category::find($id);
            $cat->cat_name     = $request->get('cat_name');
            $cat->cat_desc     = $request->get('cat_desc');
            $cat->cat_keywords = $request->get('cat_keywords');
            $cat->cat_parent   = $cat_parent;
            $cat->save();            
            $request->session()->flash('success', 'Category Has Been Updated Successfully');
            return redirect('/categories');
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
