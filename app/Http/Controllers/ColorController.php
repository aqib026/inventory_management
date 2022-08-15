<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $colors = new \App\Color;
        $search = '';
        if( $request->input('search') ){
            $search = $request->input('search');
            $colors = $colors->where('color','like','%'.$search.'%');
        }
         $colors = $colors->orderBy('id','desc')->paginate(30);
        return view('colors.index',compact('colors','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new \App\Color;
        return view('colors.create',compact('model'));
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
            'color' => 'required|unique:colors|max:255',
            'color_code' => 'required',
        ]);

        $color = new \App\Color;
        $color->color = $request->get('color');
        $color->color_code = $request->get('color_code');
        $color->color_code_2 = $request->get('color_code2');
        $color->color_code_3 = $request->get('color_code3');
        if($color->save()){
            return redirect('/colors')->with('success','Color Added Successfully!');
        }else{
            return redirect('/colors')->with('success','Insertion Failed!');            
        }

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
        $model = \App\Color::find($id);
        return view('colors.edit',compact('model'));
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
            'color' => 'required|unique:colors,id|max:255',
            'color_code' => 'required',
        ]);

        $color = \App\Color::find($id);
        $color->color = $request->get('color');
        $color->color_code = $request->get('color_code');
        $color->color_code_2 = $request->get('color_code2');
        $color->color_code_3 = $request->get('color_code3');
        if($color->save()){
            return redirect('/colors')->with('success','Color Updated Successfully!');
        }else{
            return redirect('/colors')->with('success','Insertion Failed!');            
        }
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
