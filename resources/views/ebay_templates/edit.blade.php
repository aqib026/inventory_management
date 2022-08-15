@extends('layouts.app')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Ebay template <small></small></h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Form Design <small>different form elements</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
          {!! Form::model($ebayTemplate ,['method'=>'PUT','route' => ['ebay_templates.update',$ebayTemplate->id], 'class'=>'form-horizontal form-label-left']) !!}

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Template Name <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                
                {!! Form::text('template_name',null ,['required'=>"required" ,'class'=>"form-control col-md-7 col-xs-12"]) !!}
              </div>
            </div>
           
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Template <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-6 col-xs-12">
                
                {!! Form::textarea('item_description', null ,['id'=>'descr', 'class'=>'form-control col-md-7 col-xs-12', 'required'=>"required"]) !!}
              </div>
            </div>


            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="button">Cancel</button>
                 <button class="btn btn-primary" type="reset">Reset</button>
                {!! Form::submit('Update!',['class'=>'btn btn-success']); !!}
              </div>
            </div>

          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=y5fjgeehrm6d6zyqo507jj4ec14xcomcnisnuz7u7j2odguo"></script>
<script type="text/javascript">
  /*
  $(document).ready(function() {
      tinymce.init({
                  selector: 'textarea',
                  height: 500,
                  theme: 'modern',
                  plugins: [
                     'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                     'code'],
                  toolbar: "code",
                  menubar: "tools"   
               });  
  }); */
</script>
@endsection
