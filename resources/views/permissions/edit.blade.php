@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Permission <small>UPDATE Permission</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">

                  {!! Form::model($model, ['route' => ['permissions.update',$model->id], 'method' => 'patch']) !!}

                  {!! Form::label('name', 'Unique Name')  !!}
                  {!! Form::text('name',$model->name, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('display_name', 'Display Name')  !!}
                  {!! Form::text('display_name',$model->display_name, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('description', 'Description')  !!}
                  {!! Form::text('description',$model->description, ['class' => 'form-control','required' => 'required'])  !!}

                    <div class="col-offset-6 col-sm-6 center top10" style="margin-top: 10px;">
                      {!!  Form::submit('Update Permission',['class' => 'btn btn-success'])  !!}
                    </div>

                  {!! Form::close() !!}
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection