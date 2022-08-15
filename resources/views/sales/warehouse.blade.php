@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Sales Section <small></small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <form method="post" action="{{ url('/select_warehouse') }}">
                {!! csrf_field() !!}
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Please select the item by category</h2>

                    @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 
                    
                          <div class="radio">
                            <label>
                              <input type="radio" checked="checked" value="UK" id="optionsRadios1" name="warehouse">UK Warehouse Items
                            </label>
                          </div> 
                          <div class="radio">
                            <label>
                              <input type="radio" value="PK" id="optionsRadios2" name="warehouse">Pakistan Warehouse Items
                            </label>
                          </div> 

 
                          <div class="radio">
                            <input type="submit" value="SHOP NOW" name="place_order" class="btn btn-success">
                          </div> 
          
                  </div>
                </div>
                </form>
              </div>
            </div>         
</div>
@endsection
