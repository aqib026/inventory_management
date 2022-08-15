@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Colors <small>UPDATE Color</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">

                  {!! Form::model($model, ['route' => ['colors.update',$model->id], 'method' => 'patch']) !!}

                  {!! Form::label('color', 'Color')  !!}
                  {!! Form::text('color',$model->color, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('color_code', 'Color Code')  !!}
                  <div class="input-group demo2 colorpicker-element">
                    <input type="text" name="color_code" id="color_code" value="{{ $model->color_code }}" required="" class="form-control">
                    <span class="input-group-addon"><i style="background-color: {{ $model->color_code }};"></i></span>
                  </div>
                  {!! Form::label('color_code_2', 'Color Code 2')  !!}
                  <div class="input-group demo2 colorpicker-element">
                    <input type="text" name="color_code2" id="color_code2" value="{{ $model->color_code_2 }}" class="form-control">
                    <span class="input-group-addon"><i style="background-color: {{ $model->color_code }};"></i></span>
                  </div>

                  {!! Form::label('color_code_3', 'Color Code 3')  !!}
                  <div class="input-group demo2 colorpicker-element">
                    <input type="text" name="color_code3" id="color_code3" value="{{ $model->color_code_3 }}" class="form-control">
                    <span class="input-group-addon"><i style="background-color: {{ $model->color_code }};"></i></span>
                  </div>

                    <div class="col-offset-6 col-sm-6 center top10" style="margin-top: 10px;">
                      {!!  Form::submit('Update Color',['class' => 'btn btn-success'])  !!}
                    </div>

                  {!! Form::close() !!}
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection