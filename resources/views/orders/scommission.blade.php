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

                  <div class="x_content">
                    <table id="datatable-orders" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
                        }else{
                          $commc  = $comm->comm * 0.5;
                        }

                        if($comm->paid == 0)
                          $pend_comm += $commc;
                        else
                          $paid_comm += $commc;            
                        @endphp
                      @endforeach 
                      <tbody>
                        <tr>
                          <td>Pending Commission</td>
                          <td><?php echo $pend_comm; ?></td>
                          <td>Paid Commission</td>
                          <td><?php echo $paid_comm; ?></td>
                        </tr>
                      </tbody>                      
                    </table>
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection