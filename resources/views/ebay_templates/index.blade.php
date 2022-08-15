@extends('layouts.app')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Templates <small>Ebay item description templates</small></h3>
    </div>

    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <a href=" {{ route('ebay_templates.create') }} " class="btn btn-success">ADD NEW Template</a>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Templates<small>item description templates</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          {{ $ebay_templates->links() }}
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Title</th>
                <th>Description Text</th>
                <th>User</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ebay_templates as $ebay_template)
              
              <tr>
                <td>{{ $ebay_template->template_name }}</td>
                <td>{{ str_limit($ebay_template->item_description, 100) }}</td>
                <td>{{ $ebay_template->user->name }}</td>
                <td>
                  <a href='{{ route("ebay_templates.edit",$ebay_template->id) }}'><i class="fa fa-edit"></i></a>
                  <a href='{{ route("ebay_templates.destroy",$ebay_template->id) }}' data-method="delete" data-confirm="Are you sure?" ><i class="fa fa-remove"></i></a>
                </td>
                
              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $ebay_templates->links() }}
          
          
        </div>
      </div>
    </div>
  </div>         
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/laravel.js') }}"></script>
<script>
    window.csrfToken = '<?php echo csrf_token(); ?>';
</script>
@endsection
