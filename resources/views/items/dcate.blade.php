                <div class="col-md-4">

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Fabric<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" id="fabric" name="fabric" value="{{ $item->fabric }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Location<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" id="wl" name="wl" value="{{ $item->wl }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Weight<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" id="weight" name="weight" value="{{ $item->weight }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                                                  
                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">Main Category<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">

                    <select name="main_cat_id" id="main_cat_id"  class="form-control col-md-7 col-xs-12">
                      @if($item->main_category)
                      <option value="{{ $item->main_category->cat_id }}">{{ $item->main_category->cat_name }}</option>
                      @else
                      <option value="">Select Main Category</option>
                      @endif
                      @foreach($level_one_cats as $cat)
                        <option value="{{$cat->cat_id}}">{{$cat->cat_name}}</option>
                      @endforeach
                    </select>

                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12  col-xs-12" for="first-name">2nd Category<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <select name="sec_cat_id" id="sec_cat_id"  class="form-control col-md-7 col-xs-12">
                      @if($item->sec_category)
                      <option value="{{ $item->sec_category->cat_id }}">{{ $item->sec_category->cat_name }}</option>
                      @else
                      <option value="">Select 2nd Category</option>
                      @endif
                      @foreach($sec_child_cats as $scat)
                      <option value="{{ $scat->cat_id }}">{{ $scat->cat_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">3rd Category<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <select name="category_id" id="category_id"  class="form-control col-md-7 col-xs-12">
                      @if($item->third_category)
                      <option value="{{ $item->third_category->cat_id }}">{{ $item->third_category->cat_name }}</option>
                      @else
                      <option value="">Select 3rd Category</option>
                      @endif
                      @foreach($third_child_cats as $scat)
                      <option value="{{ $scat->cat_id }}">{{ $scat->cat_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>  
                @if( Auth::user()->can('item_sale_price') )
                <div class="form-group">
                  <label class="control-label  col-md-8 col-sm-12 col-xs-12" for="first-name">Is it a repeating design for purchase?<span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-12 col-xs-12">
                    <select name="repeating" id="repeating"  class="form-control col-md-7 col-xs-12">
                      <option value="{{$item->repeating}}">{{$item->repeating}}</option>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                  </div>
                </div>  
                <div class="form-group">
                  <label class="control-label  col-md-8 col-sm-12 col-xs-12" for="first-name">Continue for sale?<span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-12 col-xs-12">
                    <select name="continue1" id="continue1"  class="form-control col-md-7 col-xs-12">
                      <option value="{{$item->continue1}}">{{$item->continue1}}</option>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                  </div>
                </div>                    
                @endif

                @if(Entrust::hasRole('salesman') || Entrust::hasRole('owner'))
                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Proposed Sale Price<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" id="proposed_sprice" name="proposed_sprice" value="{{ $item->proposed_sprice }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>                  
                @endif

              </div>