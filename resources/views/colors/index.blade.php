@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Colors <small>Manage Colors</small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <a href=" {{url('/colors/create')}} " class="btn btn-success">ADD NEW COLOR</a>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="alert alert-warning">PLEASE AVOID REPEATIONS OF COLORS AND TRY TO FIND COLOR FROM THE SEARCH FIELD BELOW, MOST OF THE COLORS ALREADY EXISTS</div>
                <div class="x_panel">
                <div class="x_title">
                  <form action="" method="get" class="form-horizontal form-label-left">
                    
                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Filter</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="search" value="{{ $search }}" required autofocus>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="{{ url('/colors') }}" class="btn btn-info">Reset</a>
                    </div>
                  </form>
                </div>
                  <div class="x_content">
                  {!! $colors->appends(Input::except('page'))->links() !!}
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Color</th>
                          <th>Color Code # 1</th>
                          <th>Color Code # 2</th>
                          <th>Color Code # 3</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach ($colors as $key => $c)
                        <tr>
                          <td> {{$key}} </td>
                          <td> {{$c->color}} </td>
                          <td>{{ $c->color_code }}</td>
                          <td>{{ $c->color_code_2 }}</td>
                          <td>{{ $c->color_code_3 }}</td>
                          <td>
                          <a href='{{ url("/colors/$c->id/edit") }}'><span class="glyphicon glyphicon-pencil"></span></a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  {!! $colors->appends(Input::except('page'))->links() !!}
          
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
