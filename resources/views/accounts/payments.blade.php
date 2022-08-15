    <div class="col-md-12 customer_credit_limit accounts">
    <div class="x_panel">
      <div class="x_title">
          <h2>Make Payments </h2>
          <p>For discount please select Payment Mode: Discount <br />
If wrong unpaid invoices appear please refresh twice !!</p>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <ul>
          @foreach($c->unpayment_invoices() as $i)
            <li><input type="checkbox" name="invoices[]" value="" />  Invoice of total : {{ $i->amount + $i->vat }} against the order <a href=' {{ url("/hawavee_orders/$i->order_id")}}' target="_blank"> {{ $i->order_id }}</a> </li>
          @endforeach
        </ul>
        <form class="form" action="{{ url('/makepayment') }}" onsubmit="return validate();" method="post">
          {!! csrf_field() !!}
          <input type="hidden" name="customer_id" value="{{$c->customer_id}}">
          <input type="hidden" name="acc_code" value="{{$c->acc_code}}">
          <input type="hidden" name="vat" value="{{$c->vat}}">
          <div class="col-md-3">
            <label>Description</label>
            <input type="text" name="desc" required="" class="form-control" />
          </div>
          <div class="col-md-2 cdd" style="display: none;" >
            <label>Cheque Due Date</label>
              <input type="text" name="cddate" value="" class="form-control" id="single_cal3">
          </div>
          <div class="col-md-2">
            <label>Amount</label>
            <input type="number" name="amount" required="" step="0.01" class="form-control" />            
          </div>
          <div class="col-md-3">
            <label>Payment Mode : </label>
            <select name="pm" id="pm" onchange="checkmethod();" required="" class="form-control">
              <option value="">Select Payment Mode</option>
              <option value="c">Cash Payment</option>
              <option value="bt">Bank Transfer</option>
              <option value="cp">Cheque Payment</option>
              <option value="card">Card Payment</option>
              <option value="d">Discount</option>
            </select>
          </div>
          <div class="col-md-2" style="padding-top: 20px;">
          <label>&nbsp;</label>
          <input type="submit" value="Make Payment" class="btn btn-warning">
          <button type="reset" value="Reset" class="btn">Reset</button>
          </div>
        </form>
      </div>
    </div>
    </div> <!-- customer_credit_limit -->

    <script type="text/javascript">
      function checkmethod(){
        if($("#pm").val() == 'cp'){
          $('.cdd').show();
        }
      }
      function validate(){
        if( $("#pm").val() == 'cp' && $("#single_cal3").val() == '' ){
          alert('Please insert Cheque Due Date'); return false;          
        }
        return true;
      }
    </script>