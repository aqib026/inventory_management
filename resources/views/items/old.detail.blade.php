@extends('layouts.app')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Item Detail <small></small></h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-6 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><small>design code : </small> : {{ $item->design_code }} </h2>
          <a href='{{ url("/dropzone/$item->design_code") }}' target="_blank" class="btn btn-info" style="float: right;">Upload Images</a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form id="demo-form2" method="post" action='{{ url("/updateitem/$item->id") }}' data-parsley-validate class="form-horizontal form-label-left">
            {!! csrf_field() !!}

            <div class="" role="tabpanel" data-example-id="togglable-tabs">


              <div id="myTabContent2" class="tab-content">

                 <!-- 1st tab closer coainter -->
                 
               <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">   

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Design Code<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="design_code" name="design_code" value="{{ $item->design_code}}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gender<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="category" id="category"  class="form-control col-md-7 col-xs-12">
                      <option value="{{ $item->category }}">{{ $item->category }}</option>
                      <option value="Womens">Womens</option>
                      <option value="Mens">Mens</option>
                      <option value="Womens">Kids</option>
                      <option value="Womens">Unisex</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Main Category<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <select name="main_cat_id" id="main_cat_id"  class="form-control col-md-7 col-xs-12">
                      @if($item->main_category)
                      <option value="{{ $item->main_category->cat_id }}">{{ $item->main_category->cat_name }}</option>
                      @else
                      <option value="">Select Main Category</option>
                      @endif
                      <option value="1">Fashion</option>
                      <option value="2">Memento / Souvenir</option>
                      <option value="51">Workwear</option>
                      <option value="72">Italian Clothing</option>
                    </select>

                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">2nd Category<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="sec_cat_id" id="sec_cat_id"  class="form-control col-md-7 col-xs-12">
                      @if($item->sec_category)
                      <option value="{{ $item->sec_category->cat_id }}">{{ $item->sec_category->cat_name }}</option>
                      @else
                      <option value="">Select 2nd Category</option>
                      @endif
                      @foreach($sec_child_cats as $scat)
                      <option value="{{ $scat->cat_id }}">{{ $scat->cat_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">3rd Category<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="category_id" id="category_id"  class="form-control col-md-7 col-xs-12">
                      @if($item->third_category)
                      <option value="{{ $item->third_category->cat_id }}">{{ $item->third_category->cat_name }}</option>
                      @else
                      <option value="">Select 3rd Category</option>
                      @endif
                      @foreach($third_child_cats as $scat)
                      <option value="{{ $scat->cat_id }}">{{ $scat->cat_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="title" name="title" value="{{ $item->title}}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Style<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="style" name="style" value="{{ $item->style }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fabric<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fabric" name="fabric" value="{{ $item->fabric }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">weight<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="weight" name="weight" value="{{ $item->weight }}" required="required" class="form-control col-md-7 col-xs-12">
                    <span style="right: 24px;" class="form-control-feedback right">Grams</span>
                  </div>
                </div>

              </div> <!-- 1st tab closer coainter -->

              <!-- 2nd tab closer coainter -->
              <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total Cost Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="total_p" name="total_p" value="{{ $item->total_p }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">GFL Cost Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="cost_price" name="cost_price" value="{{ $item->cost_price }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">B2S Cost Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="shipment_charges" name="shipment_charges" value="{{ $item->shipment_charges }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <hr >

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">GFL Sale Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="gfl_p" name="gfl_p" value="{{ $item->gfl_p }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">B2S Sale Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="b2s_p" name="b2s_p" value="{{ $item->b2s_p }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <hr >

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FWS Sale Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fws_price" name="fws_price" value="{{ $item->fws_price }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ebay Sale Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="sc_price" name="sc_price" value="{{ $item->sc_price }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ebay Postage Charges<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="sc_postc" name="sc_postc" value="{{ $item->sc_postc }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amazon Sale Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="ama_price" name="ama_price" value="{{ $item->ama_price }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amazon Postage Charges<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="ama_postc" name="ama_postc" value="{{ $item->ama_postc }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <hr >

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Drop shippers Price<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="dps_price" name="dps_price" value="{{ $item->dps_price }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
              </div> <!-- 2nd tab closer coainter -->
              
                 <input type="submit" value="Update Design" class="btn btn-info" style="float: right;" />
             
            </div> <!-- contents cainteners -->
          </div> <!-- Main tabs container -->
        </form>

        <div class="ln_solid"></div>
        <div class="row">
          <div class="col-md-12">
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
      </div>

    </div>
              </div>  <!-- CLOSING OF COL_MD_6 -->

    <div class="col-md-6 col-xs-12">
      <div class="row">
        <div class="col-md-6 col-xs-12">
        @if($item->images)
          @foreach($item->images as $img)
            <img src="http://hawavee.co.uk/nportal/itemimg/thumb/thumb_{{ $img->image }}" />
          @endforeach
        @endif
          
        </div>
        <div class="col-md-6 col-xs-12">
          
        </div>
      </div>
    </div>          
            </div>         
</div>
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