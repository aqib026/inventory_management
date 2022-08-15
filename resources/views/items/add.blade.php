@extends('layouts.app')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3><a href="{{ url('/home')}}">Items</a> <small></small></h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-12 col-xs-12">
    <form id="demo-form2" action="{{ url('/saveitem') }}" method="post" data-parsley-validate class="form-horizontal form-label-left">
      {!! csrf_field() !!}
      <div class="x_panel">
        <div class="x_title">
          <h2 style="width: 100%;"><small>design code : </small> 
          <input type="submit" name="add_item" class="btn btn-success pull-right" value="ADD DESIGN">
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
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">PUll Design Code Info<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">                               
                  <input type="text" id="pullinfos" name="pullinfos" value="" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">Design Code<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">                   
                   <input type="text" id="design_code" style="text-transform:uppercase;" name="design_code" value="{{ old('design_code') }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">BRAND<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">

                    <select name="brand" id="brand" required="required"   class="form-control col-md-7 col-xs-12">
                      <option value="">Select Brand</option>
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
                      <option value="">Select Gender</option>
                      <option value="Womens">Womens</option>
                      <option value="Mens">Mens</option>
                      <option value="Womens">Kids</option>
                      <option value="Womens">Unisex</option>
                    </select>
                  </div>
                </div>


                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">Style<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <select name="style" id="style" required="required"   class="form-control col-md-7 col-xs-12">
                      <option value="">Select a Style</option>
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
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12  col-xs-12" for="first-name">Country<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <select name="warehouse" id="warehouse" class="form-control col-md-7 col-xs-12">
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
                    <textarea name="Description" id="Description" rows="5" cols="5">{{ old('Description') }}</textarea>
                  </div>
                </div>

              </div>

              @include('items/cate')
                </div>
              <!-- 1st tab closer coainter -->
            </div>
        </form>
    
            </div>         
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {

    $( "#pullinfos" ).autocomplete({
      source: "{{ url('/designcodes')}}",
      minLength: 2,
      select: function( event, ui ) {

        $.ajax({
          type:'GET',
          url : '{{ url("/pullinfo") }}',
          data: 'design_code='+ui.item.label,
          dataType: 'json',
          success:function(response){
              $('#brand').val(response.brand);
              $('#category').val(response.category);
              $('#style').val(response.style);
              $('#title').val(response.title);
              $('#Description').val(response.Description);
              $('#fabric').val(response.fabric);
              $('#weight').val(response.weight);
              $('#main_cat_id').val(response.main_cat_id);
              $('#sec_cat_id').val(response.sec_cat_id);
              $('#category_id').val(response.category_id);
          }
        });

      }
    });

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
