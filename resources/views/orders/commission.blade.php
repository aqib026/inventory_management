@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Commission <small> on Sales Orders</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
    <form class="form-inline" method="get">
      <div class="col-md-2">
      <div class="form-group">
        <label for="exampleInputName2">Start Date</label>
        <input type="text" name="start_date" class="form-control" id="single_cal1" placeholder="Pick Start Date" value="{{ Carbon\Carbon::parse($start_date)->format('m/d/Y') }}">
      </div>
    </div>
      <div class="col-md-2">
      <div class="form-group">
        <label for="exampleInputEmail2">End Date</label>
        <input type="text" name="end_date" class="form-control" id="single_cal2" placeholder="Pick End Date" value="{{ Carbon\Carbon::parse($end_date)->format('m/d/Y') }}">
      </div>
    </div>
      <div class="col-md-2">
      <div class="form-group">
        <label for="exampleInputEmail2">Saleman</label>
        <select name="saleman" class="form-control">
          <option value="<?php echo $d_s; ?>"><?php echo $d_s; ?></option>
          <option value="shahid">shahid</option>
          <option value="usman">usman</option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-default">View Commissions</button>
    </div>
    </form>                    
                  </div>
                  <div class="x_content"> 
                    <form action="{{ url('/post_comm') }}" method="post">
                      {!! csrf_field() !!}
                    <table id="datatable-orders" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Order No.</th>
                          <th>Order Date</th>
                          <th>Sale Person</th>
                          <th>Saleman Comm</th>
                          <th>Hawavee Comm</th>
                          <th>Paid</th>
                        </tr>
                      </thead>
                      
                      <tbody>                                            
                      @php
                        $c = 1;
                        $count = 0;
                        $pend_comm = 0;
                        $paid_comm = 0;
                        $thcomm = 0;                      
                      @endphp
                      @foreach ($comms as $comm)
                      @php
                        if($comm->vat == 0){
                          $commc  = $comm->comm * 0.35;
                          $hcomm = $comm->comm * 0.65;
                        }else{
                          $commc  = $comm->comm * 0.5;
                          $hcomm = $comm->comm * 0.5;
                        }
                        $thcomm += $hcomm;
                        if($comm->paid == 0)
                          $pend_comm += $commc;
                        else
                          $paid_comm += $commc;            
                        @endphp
                        <tr>
                          <td>{{ $comm->id }}</td>
                          <td>{{ $comm->order_no }}</td>
                          <td>{{ $comm->order_date }}</td>
                          <td>{{ $comm->sale_person }}</td>
                          <td>{{ $commc }}</td>
                          <td>{{ $hcomm }}</td>
                          <td>
                            @if($comm->paid == 0) 
                              <input type="checkbox" name="make_payment[]" value="{{ $comm->id }}"> 
                            @else
                              Paid
                            @endif
                          </td>
                        </tr>
                      @endforeach 
                    
                      </tbody>
                      
                      <tfooter>
                        <tr>
                          <th>#</th>
                          <th>&nbsp;</th>
                          <th><?php echo 'Pending Comm   '.$pend_comm; ?></th>
                          <th><?php echo 'Paid Comm   '.$paid_comm; ?></th>
                          <th>&nbsp;</th>
                          <th><?php echo $thcomm; ?></th>
                          <th><input type="submit" value="Mard as Paid"></th>
                        </tr>
                      </tfooter>                      
                    </table>
                    </form>
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection