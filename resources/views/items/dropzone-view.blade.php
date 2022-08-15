@extends('layouts.app')

@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Items <small></small></h3>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2 style="width: 100%;"><small>design code : </small> 
						{{ $item->design_code }}
					</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">        
            <h4>Please upload image with dimension width= 1300px and height=1710px!</h4>
            {!! Form::open([ 'route' => [ 'dropzone.store' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
            <div class="row">
            	<div class="col-md-2">&nbsp;</div>
            	<div class="col-md-4">
            		<br />
             		<label>Upload Image</label>
            		<input type="file" name="image" id="image" required=""> 
            		<br />

            		<label>Select Color</label>
            		<select class="form-control" name="color" id="color" required="">
            			<option value="">Select Color</option>
            			@foreach($item->colors() as $color)
            				<option value="{{ $color->color }}">{{ $color->color }}</option>
            			@endforeach
                            <option value="mix">mix</option>
            		</select>            		
        		<input type="hidden" name="design_code" id="design_code" value="{{ $item->design_code }}">     

        		<br />
                <label>Set as Cover Image</label>
                <select class="form-control" name="cover" id="cover" required="">
                    <option value="0">no</option>
                    <option value="1">yes</option>
                </select>                   
                <br />
        		<input type="submit" class="btn btn-success" />
            	</div>
                <div class="col-md-1">&nbsp;</div>
            	<div class="col-md-4">
                    @foreach($item->images  as $img)
                        @php $imgc = $img->image; 
                             $image_id = $img->image_id; @endphp
                        <img src=' {{ url("public/images/thumb/$imgc")}} ' />
                        <a href='{{ url("delete_images/$image_id") }}' class="btn btn-danger">Delete Images</a>
                    @endforeach   

                </div>
            </div>
            {!! Form::close() !!}
				</div>         
			</div>
		</div>
	</div>
</div>
@endsection
