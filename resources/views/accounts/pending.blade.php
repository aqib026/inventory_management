    <div class="col-md-12 customer_credit_limit accounts">
    <div class="x_panel">
      <div class="x_title">
          <h2>Pendind Payments </h2>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table table-striped table-bordered dt-responsive nowrap">
          <tr>
            <th>Payment ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Payment Mode</th>
            <th>Status</th>
          </tr>
          @foreach($c->pending as $p)
            <tr>
              <td>{{$p->receipt_id}}</td>
              <td>{{$p->date}}</td>
              <td>{{$p->time}}</td>
              <td>{{$p->note}}</td>
              <td>{{$p->amount}}</td>
              <td>{{$p->payment_mode}}</td>
              <td>{{$p->status}}</td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
    </div> <!-- customer_credit_limit -->