@extends('layouts.app')

@section('content')
<div class="">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="page-title">
                <div class="title_left">&nbsp;</div>
                  <div class="title_right">
                    <a href="javascript:void()" class="btn btn-warning" style="float: right;">{{ $customer->business_name}}</a>
                    <a href="javascript:void()" class="btn btn-danger"  style="float: right;">{{ \Session('warehouse') }}</a>
                    <a href="{{url('/viewbucket')}}" class="btn btn-success" style="float: right;">View Bucket</a>                  
                  </div>                  
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    @include('layouts/menu')   

                 <form action="" method="get" class="form-horizontal form-label-left" style="margin-top:20px;">
                    
                    <label class="control-label col-md-2 col-sm-3 col-xs-12"> Search By Design Codes OR Keywords </label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="search" value="{{$search}}" required autofocus>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="{{ url('/listing') }}" class="btn btn-info">Reset</a>
                    </div>
                  @if($sel_cat_name != '')  <h2>Category Name : {{ $sel_cat_name->cat_name }}</h2> @endif
                  </form> 

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                  <div class="row">
                  {!! $items->appends(Input::except('page'))->links() !!}
                  <br />
                  @foreach($items as $item)
                    @if($item->cover_image )
                  <div class="col-md-3">
                    <div class="thumbnail" style="height: 300px;">
                      <div class="image view view-first" style="height: 250px; position: relative; text-align: center;">
                        @php $img = $item->cover_image->image @endphp
                        <img src=' {{ url("public/images/medium/$img")}} ' data-large='{{ url("public/images/large/$img")}}' class="myImg" onclick="showimage(this)" />
                      @php $item->colors() @endphp
                      <div class="caption"> 
                        <h2 class="heading">{{ $item->design_code }}</h2>
                        <h3 style="background-color: #26B99A; color: #fff;">Qty : {{ $item->available }}</h3>
                        <a href='{{ url("/item_detail/$item->design_code") }}' class="btn btn-info">Buy Now</a>
                      </div>
                      </div>

                    </div>
                  </div>
                    @endif
                  @endforeach
                  {!! $items->appends(Input::except('page'))->links() !!}
                    </div>
          
          
                  </div>
                </div>
              </div>

            </div>         
</div>

<style type="text/css">
    .caption{ position: absolute; bottom: 10px; text-align: center; width: 100%; background:transparent; }
    .heading{  margin-top: -20px; background-color: #0D1F46; padding: 3px; color: #fff;  text-align: center; }
    .view img { height: 230px; width: 190px; margin: 0 auto; }
</style>


  @include('imagepopup')
@endsection
