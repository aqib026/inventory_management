
<table style="width: 100%; border: 1px solid #eee;">
	<tr>
		<td>Item No</td>
		<td>Design Code</td>
		<td>Item Code</td>
		<td>Size</td>
		<td>Color</td>
		<td>Available in Warehouse</td>
		<td>Available For Sale</td>
	</tr>

	@forelse($item->sizeAndColors as $isc) 
	<tr>
		<td>{{$isc->item_sc_code}}</td>
		<td>{{$isc->design_code}}</td>
		<td>{{$isc->item_sku_code}}</td>
		<td>{{$isc->size}}</td>
		<td>{{$isc->color}}</td>
		<td>{{$isc->available_in_warehouse}}</td>
		<td>{{$isc->aqty}}</td>
	</tr>
	@empty
	@endforelse
	
</table>