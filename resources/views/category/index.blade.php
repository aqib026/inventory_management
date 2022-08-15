@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Categories <small>Manage Categories</small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <a href=" {{url('/categories/create')}} " class="btn btn-success">ADD NEW CATEGORY</a>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <div class="x_content">
                  {{ $cats->links() }}
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Parent Category</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach ($cats as $key => $cat)
                        <tr>
                          <th>{{ $key }}</th>
                          <td>{{ $cat->cat_name }}</td>
                          <td>{{ $cat->cat_desc }}</td>
                          <td>@if($cat->parent) {{ $cat->parent->cat_name }} @endif</td>
                          <td>
                          <a href='{{ url("/categories/$cat->cat_id/edit") }}'><span class="glyphicon glyphicon-pencil"></span></a>
                          <form action="{{ route('categories.destroy',$cat->cat_id) }}" method="POST">
                              {{ method_field('DELETE') }}
                              {{ csrf_field() }}
                              <button type="submit" value="submit"><span class="glyphicon glyphicon-remove"></span></button>
                          </form>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                    {{ $cats->links() }}
          
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
