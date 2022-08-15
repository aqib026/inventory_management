@extends('layouts.app')

@section('content')


<div class="">

            <div class="page-title">
              <div class="title_left">
                <h3>Messages <small style="color: red;">
                </small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  @include('message/search')
                  <div class="x_content">
                    <table id="table" class="hover table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Type</th>
                          <th>Message ID</th>
                          <th>Customer ID</th>
                          <th>customer Name</th>
                          <th>Message</th>
                          <th>Time</th>
                          <th>Date (YYYY-MM-DD)</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($messages as $message)
                        <tr>
                          <td>{{$message->type}}</td>
                          <td><a href="/message/{{$message->message_id}}">{{$message->message_id}}</a></td>
                          <td>{{$message->customer_id}}</td>
                          <td>{{$message->customer_name}}</td>
                          <td >{{$message->message}}</td>
                          <td>{{$message->time}}</td>
                          <td>{{$message->created_at}}</td>
                        </tr>
                      @endforeach 
                      </tbody>
                    </table>
                   
          
        

                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
@section('scripts')
<!-- datatable -->
 <script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
            $('#table').DataTable({
                "paging"  : true,
                "ordering": true,
                "info"    : false
            });
    });
    </script>
     <!-- datatable -->
@stop