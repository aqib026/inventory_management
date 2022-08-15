@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Categories <small>Add New Categories</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">

                  {!! Form::model($model, ['route' => ['categories.update',$model->id] , 'method' => 'put']) !!}

                  {!! Form::label('cat_name', 'Category Name')  !!}
                  {!! Form::text('cat_name',$model->cat_name, ['class' => 'form-control'])  !!}

                  {!! Form::label('cat_desc', 'Category Description')  !!}
                  {!! Form::textarea('cat_desc',$model->cat_desc, ['class' => 'form-control','rows' => 4])  !!}

                  {!! Form::label('cat_keywords', 'Category Keywords')  !!}
                  {!! Form::text('cat_keywords',$model->cat_keywords, ['class' => 'form-control'])  !!}

                  {!! Form::label('cat_parent', 'Parent Category')  !!}
                  @if($cats)
                    <ul>
                    @foreach($cats as $cat)
                      <li>
                        {!! Form::radio('cat_parent', $cat->id ) !!} {{ $cat->cat_name}}
                        @if($cat->child())
                          <ul>
                            @foreach($cat->child as $c)
                            <li>{!! Form::radio('cat_parent', $c->id ) !!} {{ $c->cat_name}}</li>
                            @endforeach
                          </ul>
                        @endif
                      </li>
                    @endforeach
                    </ul>
                  @endif

                  <div class="row">
                  {!!  Form::submit('Update Category',['class' => 'btn btn-success'])  !!}
                  </div>

                  {!! Form::close() !!}
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
