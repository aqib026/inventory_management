<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pullinfo(Request $r){
        $item = \App\Item::where('design_code',$r->design_code)->first();
        echo json_encode($item);
    }
    public function item_sc_detail($dc){
        $item = \App\Item::where('design_code',$dc)->first();
        return view('items/scdetail',compact('item')); 
    }

    public function save_sc(Request $request){
        $colors = \App\Color::where('color',$request->get('new_color'))->get();
        if(!$colors->count()){
            $nc = new \App\Color;
            $nc->color = $request->get('new_color');
            $nc->save();
        }
        $c_sc = \App\ItemSizeColor::where('color',$request->get('new_color'))->where('size',$request->get('new_size'))->where('design_code',$request->get('design_code'))->get();

        if($c_sc->count()){
            return back()->with('error','Combination alread exists');
        }else{
            $csc = new \App\ItemSizeColor;
            $csc->design_code   = $request->get('design_code');
            $csc->item_sku_code = $request->get('design_code').'-'.$request->get('new_color').'-'.$request->get('new_size');
            $csc->size          = $request->get('new_size');
            $csc->color         = $request->get('new_color');
            $csc->no_in_stock   = 0;
            $csc->no_in_order   = 0;
            $csc->last_stock_in = 0;
            $csc->qty = 0;
            $csc->aqty = 0;
            $csc->persent_sold = 0;
            $csc->save();
            return back()->with('success','New Combination Added successfully');
        }
    }

    public function colors_list(Request $r){
        $colors = \App\Color::where('color','like','%'.$r->get('term').'%')->pluck('color');
        return json_encode($colors);
    }

    public function designcodes(Request $r){
        $colors = \App\Item::where('design_code','like','%'.$r->get('term').'%')->pluck('design_code');
        return json_encode($colors);
    }


    public function dashboard(Request $request){
         if( Auth::User()->can('manage_ebay') ){
            $id = Auth::User()->member_id;

            $user = \App\User::where('member_id',$id)->first();

            if($user->ebay_token == null){

            }
         }

        //$quantity_info = \App\Order::select(\DB::raw('SUM(require_qty) as rqty,design_code'))->join('order_line', function($q){   $q->on('orders.order_no','order_line.order_no');
        //            })->where('orders.order_status','!=','delivered')->where('orders.order_status','!=','canceled')->groupby('order_line.design_code')->paginate(10);
         return view('welcome');
    }


    /**
     * Generate Image upload View
     *
     * @return void
     */
    public function dropzone($dc)
    {
        $item = \App\Item::where('design_code',$dc)->first();
        return view('items/dropzone-view',compact('item'));
    }

    /**
     * Image Upload Code
     *
     * @return void
     */
    public function dropzoneStore(Request $request)
    {
        $this->validate($request, [
             'image' => 'dimensions:min_width=1300,min_height=1710'
        ]);

        $image = $request->file('image');
        $imageName = time().$image->getClientOriginalName();
        $image->move(public_path('images/original'),$imageName);

        Image::make(public_path('images/original/'.$imageName))->resize(900, 1183)->save(public_path('images/large/'.$imageName));
        Image::make(public_path('images/original/'.$imageName))->resize(268, 352)->save(public_path('images/medium/'.$imageName));
        Image::make(public_path('images/original/'.$imageName))->resize(80, 105)->save(public_path('images/thumb/'.$imageName));

        if($request->get('cover') == 1){
            \DB::table('item_images')
                    ->where('design_code', $request->get('design_code'))
                    ->update(['cover' => 0]);            
        }
        $model = new \App\ItemImages;
        $model->design_code = $request->get('design_code');
        $model->color       = $request->get('color');
        $model->image       = $imageName;
        $model->date_added  = date('Y-m-d');
        $model->cover       = $request->get('cover');
        $model->save();
        return back()->with(['success'=>'Image uploaded successfully']);
    }    

    public function getcat_child(){
        $cats = \App\Category::where('cat_parent',$_GET['catid'])->get();
        echo "<option value='' >Select Second</option>";
        foreach($cats as $cat){
            echo "<option value='".$cat->cat_id."' >".$cat->cat_name."</option>";
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = \App\Item::orderBy('id', 'desc');
        $conti = 'yes';
        $search = '';
        $wh = 'All Items';
        if( $request->input('wh') ){
            $wh    = $request->input('wh');
            $items = $items->where('warehouse',$wh);
            
            if(strtoupper($wh) == 'PK'){
                $wh= 'Pakistan';
            }
            $wh = 'Items in '.$wh.' Warehouse';
        }
        if( $request->input('c') ){
            $conti = $request->input('c');
            $items = $items->where('continue1',$conti);
        }else{
            $items = $items->where('continue1','yes');
        }
        if( $request->input('search') ){
            $search = $request->input('search');
            $filter_by = $request->input('filter_by');
            $items = $items->where('design_code','like','%'.$search.'%');
        }
        if(\Entrust::hasRole('supplier')){
            $items = $items->where('design_code','like','MH_2%');
        }
        $items = $items->paginate(25);
        return view('home',compact('items','search','conti','wh'));
    }

    public function repeating(Request $request)
    {
        $items = \App\Item::orderBy('id', 'desc');
        $conti = 'hide';
        $search = '';
        $wh = 'Items by Warehouse';
        if( $request->input('search') ){
            $search = $request->input('search');
            $filter_by = $request->input('filter_by');
            $items = $items->where('design_code','like','%'.$search.'%');
        }

        $items = $items->where('repeating','yes');
        $items = $items->paginate(25);
        return view('home',compact('items','search','conti','wh'));
    }

    

    public function size_colors($id)
    {
        $item = \App\Item::find($id);
        $c = 0;
        foreach($item->sizeAndColors as $isc){
            $av = $isc->getqty1($isc->item_sc_code);            
            $c += $av[1]; 
        }
        $item->available = $c;
        $item->save();
        $item = \App\Item::find($id);

        return view('items.sc',compact('item'));
    }

    public function save(Request $request)
    {
        
        $validation = $this->validate($request, [
            'title'        => 'required|unique:items|max:255',
            'design_code'  => 'required|unique:items|max:255',
            'category'     => 'required',
            'main_cat_id'  => 'required',
            'sec_cat_id'   => 'required',
            'category_id'  => 'required',            
            'brand'        => 'required',            
            'style'        => 'required',            
            'warehouse'    => 'required',
            'Description'  => 'required',     
            'fabric'       => 'required',
            'weight'       => 'required',
        ]);

        $item = new \App\Item;
        $item->design_code  = $request->get('design_code');
        $item->brand        = $request->get('brand');
        $item->category     = $request->get('category');
        $item->style        = $request->get('style');
        $item->title        = $request->get('title');
        $item->warehouse    = $request->get('warehouse');
        $item->Description  = $request->get('Description');
       
        $item->fabric       = $request->get('fabric');
        $item->weight       = $request->get('weight');
        $item->main_cat_id  = $request->get('main_cat_id');
        $item->sec_cat_id   = $request->get('sec_cat_id');
        $item->category_id  = $request->get('category_id');

        if($request->get('repeating') != '')
            $item->repeating    = $request->get('repeating');

        if(\Entrust::hasRole('salesman')){
            $item->proposed_sprice    = $request->get('proposed_sprice');
            $item->continue1          = 'yes';            
        }

 
        $item->save();

            return redirect("/item_details/$item->id")->with('success','Item added successfully,Please add images of the item');        
    }

    public function add()
    {
        $brands = \App\Brands::all();
        $styles = \App\Styles::all();
        $level_one_cats  = \App\Category::where('cat_parent',0)->get();
        $design_code  = \App\Item::select(\DB::raw('design_code'))->pluck('design_code','design_code');
        return view('items/add')->with('styles',$styles)->with('brands',$brands)->with('level_one_cats',$level_one_cats)->with('design_code',$design_code);
    }

    public function detail($id)
    {
        $brands = \App\Brands::all();
        $styles = \App\Styles::all();

        $item = \App\Item::findOrFail($id);
        $level_one_cats  = \App\Category::where('cat_parent',0)->get();
        $sec_child_cats = array();
        $third_child_cats = array();
        if($item->main_category){
            $sec_child_cats  = \App\Category::where('cat_parent',$item->main_category->cat_id)->get();
        }

        if($item->sec_category){
            $third_child_cats = \App\Category::where('cat_parent',$item->sec_category->cat_id)->get();
        }

        $ebay_templates = auth()->user()->ebayTemplates->pluck('template_name','id');

        return view('items/detail')->with('item', $item)->with('sec_child_cats', $sec_child_cats)->with('third_child_cats', $third_child_cats)->withEbayTemplates($ebay_templates)->with('brands', $brands)->with('styles', $styles)->with('level_one_cats', $level_one_cats);
    }

    public function update(Request $request,$id)
    {
        $validation = $this->validate($request, [
            'title' => 'required|unique:items,id|max:255',
            //'design_code' => 'required|unique:items,id|max:255',
            'category' => 'required',
            'main_cat_id' => 'required',
            'sec_cat_id' => 'required',
            'category_id' => 'required',            
        ]);

        $item = \App\Item::find($id);
        $item->title       =  $request->get('title');
        $item->brand        = $request->get('brand');
        $item->category  = $request->get('category');
        $item->main_cat_id  = $request->get('main_cat_id');
        $item->sec_cat_id  = $request->get('sec_cat_id');
        $item->category_id  = $request->get('category_id');
        $item->title  = $request->get('title');
        $item->style  = $request->get('style');
        $item->fabric  = $request->get('fabric');
        $item->wl  = $request->get('wl');
        $item->weight  = $request->get('weight');

        $item->warehouse    = $request->get('warehouse');
        $item->Description  = $request->get('Description');

        if( Auth::user()->can('item_sale_price') ){
            $item->total_p  = $request->get('total_p');
            $item->cost_price  = $request->get('cost_price');
            $item->shipment_charges  = $request->get('shipment_charges');
            $item->gfl_p  = $request->get('gfl_p');
            $item->b2s_p  = $request->get('b2s_p');
            $item->fws_price  = $request->get('fws_price');
            $item->sc_price  = $request->get('sc_price');
            $item->sc_postc  = $request->get('sc_postc');
            $item->ama_price  = $request->get('ama_price');
            $item->ama_postc  = $request->get('ama_postc');
            $item->dps_price  = $request->get('dps_price');
        }

        if($request->get('repeating') != '')
            $item->repeating    = $request->get('repeating');

        if($request->get('continue1') != '')
            $item->continue1    = $request->get('continue1');

        if($request->get('proposed_sprice') != '')
            $item->proposed_sprice    = $request->get('proposed_sprice');

        $item->save();            
        return back()->with('success','Products updated successfully');

    }

 public function delete_images(Request $request,$id)
    {
        $item = \App\ItemImages::where('image_id', $id)->delete();

        //$item->image = "";
       
        //$item->save();            
        return back()->with('success','Products updated successfully');

    }

}
