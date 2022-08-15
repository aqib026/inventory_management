@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Message # {{$messages->message_id}} <small style="color: red;">
                </small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                  


                    <table id="datatable-orders" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width: 50%">
                      <thead>
                        <tr>
                          <th>Customer ID</th>
                          <th>{{$messages->customer_id}}</th>
                        </tr>
                        
                        <tr>
                          <th>Customer Name</th>
                          <th>{{$messages->customer_name}}</th>
                        </tr>

                         <tr>
                          <th>Message</th>
                          <th>{{$messages->message}}</th>
                        </tr>

                        <tr>
                          <th>Orders Recieved</th>
                          <th>{{$messages->orders_recieved}}</th>
                        </tr>

                        <tr>
                          <th>Payment Recieved</th>
                          <th>{{$messages->payment_recieved}}</th>
                        </tr>

                        @if($messages->payment_recieved == 'yes')
                        <tr>
                          <th>Amount</th>
                          <th>{{$messages->amount}}</th>
                        </tr>
                        @endif

                        <tr>
                          <th>Time</th>
                          <th>{{$messages->time}} minutes</th>
                        </tr>

                        <tr>
                          <th>Date</th>
                          <th>{{$messages->created_at}}</th>
                        </tr>

                      </thead>
                    </table>



          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection