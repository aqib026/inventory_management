<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderline extends Model
{
   protected $table = 'order_line';
   public $primaryKey = 'entry_id';
   public $timestamps = false;     

  public function orderinfo()
  {
    return $this->belongsTo('App\Order','order_no','order_no');
  }

	public function design_detail()
	{
		return $this->belongsTo('App\Item','design_code','design_code');
	}
	
    public function cover_image()
    {
        return $this->hasOne('App\ItemImages','design_code','design_code')->where('cover', 1);
    }

    public function item_size_color(){
      return $this->belongsTo('App\ItemSizeColor','item_no','item_sc_code');
    }
}
