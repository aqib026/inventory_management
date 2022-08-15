
  @foreach($size as $k=>$s)
<div class="form-group">
  	<lable class="control-label col-md-4 col-sm-4 col-xs-12">Size : {{$s}}</lable>
	<div class="col-md-8 col-sm-8 col-xs-12">
	  <input type="text" class="form-control qty" id="{{$s}}" name="size[{{$s}}]" value="" required="" />
	</div>
</div>
  @endforeach
<div class="form-group">
  	<lable class="control-label col-md-4 col-sm-4 col-xs-12">Weight :</lable>
	<div class="col-md-8 col-sm-8 col-xs-12">
	  <input type="text" class="form-control" id="weight" name="weight" value="" required="" />
	</div>
</div>