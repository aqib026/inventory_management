<?php

namespace App\Http\Controllers;

use App\EbayTemplate;
use Illuminate\Http\Request;

class EbayTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ebay_templates = EbayTemplate::with('user')->paginate(10);

        return view('ebay_templates.index',compact('ebay_templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ebay_templates.add');
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
            'template_name' => 'required|max:255',
            'item_description' => 'required',
        ]);
        
        $template = auth()->user()->ebayTemplates()->create($request->only('template_name','item_description'));

        if($template){
            return redirect()->back()->with('success',"New template created successfully.");    
        }else{
            return redirect()->route('ebay_templates.index')->with('error',"Failed to create template please try again later.");
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EbayTemplate  $ebayTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(EbayTemplate $ebayTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EbayTemplate  $ebayTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(EbayTemplate $ebayTemplate)
    {
        return view('ebay_templates.edit', compact('ebayTemplate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EbayTemplate  $ebayTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EbayTemplate $ebayTemplate)
    {

        $this->validate($request, [
            'template_name' => 'required|max:255',
            'item_description' => 'required',
        ]);
        $data = $request->only('template_name','item_description');
        
        if($ebayTemplate->update($data)){
            return redirect()->route('ebay_templates.index')->with('success',"New template updated successfully.");
        }else{
            return redirect()->route('ebay_templates.index')->with('error',"Failed to update template please try again later.");
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EbayTemplate  $ebayTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EbayTemplate $ebayTemplate)
    {
        if($ebayTemplate->delete()){
            return redirect()->route('ebay_templates.index')->with('success',"Template deleted successfully.");
        }else{
            return redirect()->route('ebay_templates.index')->with('error',"Failed to delete template please try again later.");
        }
    }
}
