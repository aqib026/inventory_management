@extends('layouts.app')

@section('content')
<div class="">

<style>
.dropbtn {border: none;}
.dropdown {position: relative;display: inline-block;}
/* Dropdown Content (Hidden by Default) */
.dropdown-content {    display: none;position: absolute;background-color: #f9f9f9;width: 100%;min-width: 160px;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);z-index: 1;}
/* Links inside the dropdown */
.dropdown-content a {color: black;padding: 12px 16px;text-decoration: none;display: block;}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #f18d18;}
</style>

            <div class="page-title">
              <div class="title_left">
                <h3>Items <small>
                @if($conti != 'hide')
                  Complete list of all the items
                @else
                  List of Repeating Items only!
                @endif
              </small></h3>
              </div>

              @if(!Entrust::hasRole('supplier'))
              <div class="title_right">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right top_search">
                  <a href=" {{url('/add')}} " class="btn btn-success">ADD NEW ITEM</a>
                  @if($conti != 'hide')
                  @if($conti == 'yes')
                    <a href=" {{url('/home?c=no')}} " class="btn btn-info">Non Continue</a>
                  @else
                    <a href=" {{url('/home?c=yes')}} " class="btn btn-info">Continue</a>
                  @endif 
                  @endif
                  
                  <!--a href="javascript:void(0)" class="btn btn-warning"> {{$wh}}</a-->
                  <div class="dropdown">
  					<a href="javascript:void(0)" class="dropbtn btn btn-warning"> {{$wh}} </a>
					<div class="dropdown-content">
    					<a href="{{url('/home')}}">All Items</a>
    					<a href="{{url('/home?wh=PK')}}">Pakistan Items</a>
    					<a href="{{url('/home?wh=UK')}}">UK Items</a>
  					</div>
				  </div>
                </div>
              </div>
               @endif
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <div class="x_title">
                  <form action="" method="get" class="form-horizontal form-label-left">
                    
                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Filter</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="search" value="{{ $search }}" required autofocus>
                    <input type="hidden" name="c" value="{{ $conti }}">
                    </div>


                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="{{ url('/home') }}" class="btn btn-info">Reset</a>
                    </div>
                  </form>
                </div>
                  <div class="x_content">
                  {!! $items->appends(Input::except('page'))->links() !!}
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>&nbsp;</th>
                          <th>&nbsp;</th>
                          <th>Qty</th>
                          <th>Design Code</th>
                          <th>Image </th>
                          <th>Category</th>
                          <th>Location</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($items as $item)
                        <tr>
                          <td>@if(!Entrust::hasRole('supplier'))<a href='{{ url("/item_details/$item->id")}}'>view</a>@endif</td>
                          <td><a href='{{ url("/size_colors/$item->id")}}' class="btn btn-info modal_link">view stock</a></td>
                          <td>{{ $item->available }}</td>
                          <td>{{ $item->design_code }}</td>
                          <td>
                          @if($item->cover_image)
                            <!-- <img src="http://hawavee.co.uk/nportal/itemimg/thumb/thumb_{{ $item->cover_image->image }}" /> -->
                            @php $img = $item->cover_image->image @endphp
                            <img src=' {{ url("public/images/thumb/$img")}} ' />
                          @endif
                          </td>
                          <td>
                          @if($item->main_category)
                            {{ $item->main_category->cat_name }} , 
                          @endif
                          @if($item->sec_category)
                            {{ $item->sec_category->cat_name }}  , 
                          @endif
                          @if($item->third_category)
                            {{ $item->third_category->cat_name }} 
                          @endif
                          </td>
                          <td>{{ $item->wl }}</td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  {!! $items->appends(Input::except('page'))->links() !!}
          
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
