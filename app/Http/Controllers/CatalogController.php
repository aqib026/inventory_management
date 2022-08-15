<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    //

    public function index(Request $request){

        $items = \App\Item::orderBy('id', 'desc');
        $conti = 'yes';
        $search = '';
        if( $request->input('search') ){
            $search = $request->input('search');
            $filter_by = $request->input('filter_by');
            $items = $items->where('design_code','like','%'.$search.'%');
        }
        $items = $items->where('continue1',$conti);
        $items = $items->paginate(25);
        return view('catalog.index',compact('items','search','conti'));

    }

    public function detail($id){

        $item = \App\Item::find($id);
        return view('catalog.ecom',compact('item'));

    }

}
