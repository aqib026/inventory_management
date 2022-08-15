@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Roles <small>UPDATE roles</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">

                  {!! Form::model($model, ['route' => ['roles.update',$model->id], 'method' => 'patch']) !!}

                  {!! Form::label('name', 'Unique Name')  !!}
                  {!! Form::text('name',$model->name, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('display_name', 'Display Name')  !!}
                  {!! Form::text('display_name',$model->display_name, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('description', 'Description')  !!}
                  {!! Form::text('description',$model->description, ['class' => 'form-control','required' => 'required'])  !!}

                    <div class="col-offset-6 col-sm-6 center top10" style="margin-top: 10px;">
                      {!!  Form::submit('Update Role',['class' => 'btn btn-success'])  !!}
                    </div>

                  
          
                  </div>
                </div>
              </div>

              <div class="col-md-8 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">
                    @foreach($permissions as $p)
                    @php
                      $chckd = ""; 
                      if(in_array($p->id,$assign_perms)){
                        $chckd = "checked='checked'";
                    }
                    @endphp
                    <div class="col-md-3">
                      <div class="checkbox">
                        <label>

                        <input type="checkbox" {{ $chckd }} name="permissions[]" value="{{ $p->id }}">{{ $p->display_name }}
                        </label>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>     
              {!! Form::close() !!}             
            </div>         
</div>
@endsection