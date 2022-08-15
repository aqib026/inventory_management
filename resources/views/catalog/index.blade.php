@extends('layouts.blank')

@section('content')
<div class="">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="page-title">
                <div class="title_left">&nbsp;</div>                
                </div>
                <div class="x_panel">
                  <div class="x_title">
                 <form action="" method="get" class="form-horizontal form-label-left" style="margin-top:20px;">
                    
                    <label class="control-label col-md-2 col-sm-3 col-xs-12"> Search By Design Codes OR Keywords </label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="search" value="{{$search}}" required autofocus>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="{{ url('/catalog') }}" class="btn btn-info">Reset</a>
                    </div>
                  </form> 

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                  <div class="row">
                  {!! $items->appends(Input::except('page'))->links() !!}
                  <br />
                  @foreach($items as $item)
                  @if( isset($item->cover_image))
                  <div class="col-md-4">
                    <div class="thumbnail" style="height: 350px;">
                      <div class="image view view-first" style="height: 300px; text-align: center;">
                      @if($item->cover_image)
                        @php $img = $item->cover_image->image @endphp
                        <img src=' {{ url("public/images/medium/$img")}} ' />                      
                      @endif
                      @php $item->colors() @endphp
                      <div class="caption"> 
                        <h2 class="heading">{{ $item->design_code }}</h2>
                        <strong>Available Colors: @foreach($item->colors() as $c) {{$c->color}} ,  @endforeach</strong>
                        <a href='{{ url("/catalog_detail/$item->id") }}' class="btn btn-info">View Detail</a>
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
    .caption{ height: 230px; width: 150px; margin-left: 10px; float: left; }
    h2 .heading{ margin-top: -20px; background-color: #0D1F46; color: #fff; text-align: center; }
    .view img { height: 300px; width: 60%; margin-left: 10px;  float: left; }
</style>
@endsection