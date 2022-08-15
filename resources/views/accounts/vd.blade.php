@extends('layouts.blank')

@section('content')
<h4> @if($st == 1) GFL Account @else B2S Account @endif </h4>
<table class="table table-striped table-bordered dt-responsive nowrap">
	<tr>
		<td colspan="1">Voucher ID</td>
		<td colspan="1">{{ $v->voucher_id }}</td>
		<td colspan="1">Voucher Date</td>
		<td colspan="1">{{ $v->date }}</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="1">Prepaired By</td>
		<td colspan="1">{{ $v->prepaired_by }}</td>
		<td colspan="1">Voucher Type </td>
		<td colspan="1">Receipt Voucher</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="1">Verified By</td>
		<td colspan="1">{{ $v->checked_by }}</td>
		<td colspan="1">Description</td>
		<td colspan="1">{{ $v->description }}</td>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<table class="table table-striped table-bordered dt-responsive nowrap">
	<tr>
		<td>Account Code</td>
		<td>Account Title</td>
		<td>Account Head</td>
		<td>Narration</td>
		<td>Dr</td>
		<td>Cr</td>
	</tr>

	@forelse($v->detail as $d) 
	<tr>
		<td>{{$d->account_code}}</td>
		<td>{{$d->account_title}}</td>
		<td>{{$d->account_cat}}</td>
		<td>{{$d->narration}}</td>
		<td>{{$d->dr}}</td>
		<td>{{$d->cr}}</td>
	</tr>
	@empty
	@endforelse
	
</table>
@endsection