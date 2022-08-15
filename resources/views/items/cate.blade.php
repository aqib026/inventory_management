                <div class="col-md-4">

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Fabric<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" id="fabric" name="fabric" value="{{ old('fabric') }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Weight<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" id="weight" name="weight" value="{{ old('weight') }}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                                                  
                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">Main Category<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">

                    <select name="main_cat_id" id="main_cat_id"  class="form-control col-md-7 col-xs-12">
                      <option value="">Select Main Category</option>
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
                      <option value="">Select 2nd Category</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">3rd Category<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <select name="category_id" id="category_id"  class="form-control col-md-7 col-xs-12">
                      <option value="">Select 3rd Category</option>
                    </select>
                  </div>
                </div>  
                 @if( Auth::user()->can('item_sale_price') )
                <div class="form-group">
                  <label class="control-label  col-md-8 col-sm-12 col-xs-12" for="first-name">Is it a repeating design for purchase?<span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-12 col-xs-12">
                    <select name="repeating" id="repeating"  class="form-control col-md-7 col-xs-12">
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                  </div>
                </div>                
                @endif

                @if(Entrust::hasRole('salesman'))
                <div class="form-group">
                  <label class="control-label  col-md-4 col-sm-12 col-xs-12" for="first-name">Proposed Sale Price<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" id="proposed_sprice" name="proposed_sprice" value="" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>                  
                @endif


              </div>