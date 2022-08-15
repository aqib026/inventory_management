@extends('layouts.app')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3><a href="{{ url('/home')}}">Items</a> <small></small>
                    @foreach($item->images  as $img)
                        @php $img = $img->image @endphp
                        <img src=' {{ url("public/images/thumb/$img")}} '  data-large='{{ url("public/images/large/$img")}}' class="myImg" onclick="showimage(this)"  />
                    @endforeach   

      </h3>
    </div>
    <div class="title_right">
          {!! Form::open(['route' => ['ebay_post_items', $item->id ], 'class'=>'form-horizontal form-label-left']) !!}

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Template</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                {!! Form::Select('template_id', $ebay_templates, null , ['class'=>'select2_single form-control']) !!}
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                {!! Form::submit('Post on Ebay',['class'=>'btn btn-primary']); !!}
                <a href='{{ url("/upload_on_fws/{$item->design_code}") }}' target="_blank"  class='btn btn-warning'>Post on FWS</a>
              </div>
            </div>

            {!! Form::close() !!}
    </div>    
  </div>
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-12 col-xs-12">
    <form id="demo-form2" action='{{ url("/updateitem/$item->id") }}' method="post" data-parsley-validate class="form-horizontal form-label-left">
      {!! csrf_field() !!}
      <div class="x_panel">
        <div class="x_title">
          <h2 style="width: 100%;"><small>design code : </small> 
          <a href='{{ url("size_colors/$item->id") }}' style="float: right;" class="btn btn-info modal_link">view stock</a>  
          <a href='{{ url("/dropzone/$item->design_code") }}' target="_blank" class="btn btn-info" style="float: right;">Upload Images</a>
          <input type="submit" name="add_item" class="btn btn-success pull-right" value="UPDATE DESIGN">
          </h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">Design Code<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">                   
                   <input type="text" id="design_code" style="text-transform:uppercase;" name="design_code" value="{{ $item->design_code}}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">BRAND<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">

                    <select name="brand" id="brand" required="required"   class="form-control col-md-7 col-xs-12">
                      <option value="{{ $item->brand}}">{{ $item->brand}}</option>
                      @foreach($brands as $brand)
                        <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
                      @endforeach
                    </select>

                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">Gender<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <select name="category" id="category"  class="form-control col-md-7 col-xs-12">
                      <option value="{{ $item->category }}">{{ $item->category }}</option>
                      <option value="Womens">Womens</option>
                      <option value="Mens">Mens</option>
                      <option value="Kids">Kids</option>
                      <option value="Unisex">Unisex</option>
                    </select>
                  </div>
                </div>


                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">Style<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <select name="style" id="style" required="required"   class="form-control col-md-7 col-xs-12">
                      <option value="{{ $item->style }}">{{ $item->style }}</option>
                      @foreach($styles as $style)
                        <option value="{{$style->style}}">{{$style->style}}</option>
                      @endforeach

                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Title<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" id="title" name="title" value="{{ $item->title }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12  col-xs-12" for="first-name">Country<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <select name="warehouse" id="warehouse" class="form-control col-md-7 col-xs-12">
                      <option value="{{ $item->warehouse }}">{{ $item->warehouse }}</option>
                      <option value="UK">United Kingdom</option>
                      <option value="PK">Pakistan</option>                      
                    </select>
                  </div>
                </div>

                <!-- TEXT EDITOR STARTS HERE -->
                <!-- TEXT EDITOR STARTS HERE -->
                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Descriptions<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <textarea name="Description" id="Description" rows="5" cols="5">{{ $item->Description }}</textarea>
                  </div>
                </div>

              </div>

              @include('items/dcate')

              @if( Auth::user()->can('item_sale_price') )
                @include('items/price')
              @endif
                </div>
              <!-- 1st tab closer coainter -->
            </div>
        </form>            
            </div>         
</div>

  @include('imagepopup')
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {

    if($('#main_cat_id').length > 0){
        $('#main_cat_id').change(function(){

        $.ajax({
            type:'GET',
            url: '{{ url("/getchildcats") }}',
            data:'catid='+ $(this).val(),
            success:function(response){
                $('#sec_cat_id').html(response);
            }
            });

        });
    }

    if($('#sec_cat_id').length > 0){
        $('#sec_cat_id').change(function(){

        $.ajax({
            type:'GET',
            url:'{{ url("/getchildcats") }}',
            data:'catid='+ $(this).val(),
            success:function(response){
                $('#category_id').html(response);
            }
            });

        });
    }
});
</script>
@endsection
