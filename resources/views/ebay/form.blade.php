<form id="demo-form2" action="{{ url('/save_hawavee_cats') }}" method="post" data-parsley-validate class="form-horizontal form-label-left">
 {!! csrf_field() !!}

 @foreach($cats as $cat)
 	{{$cat->cat_id}} -- {{$cat->cat_name}} 
 	<?php 
 	$match = \App\EbayHawaCat::where('hawavee_id',$cat->cat_id)->first(); 
 	$v = '';
 	if($match != null) $v = $match->ebay_id;
 	?>
 	<input type="text" name="ebay_cat[{{$cat->cat_id}}]" value="{{$v}}" > <br /><br />
 @endforeach

 	<input type="submit" value="Submit">
</form>