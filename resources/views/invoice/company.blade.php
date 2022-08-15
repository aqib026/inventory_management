    <div class="col-xs-12" style="text-align: center;">
      <h2>{{ $order->company->name }}</h2>
      <p>{{ $order->company->address }}, {{ $order->company->postcode }} <br />
        Tel: {{ $order->company->tel_no }},<br />
        Registration No: {{ $order->company->registration_no }} <br /></p>
        <hr />
      @if($order->customer->vat == 1)
      <h2>****** Invoice To ****** </h2>
      @else
      <h2>****** Delivery Note ****** </h2>
      @endif
    </div>