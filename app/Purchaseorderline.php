<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchaseorderline extends Model
{
    //
	protected $table = 'p_order_line1';
    public $primaryKey = 'entry_id';
    public $timestamps = false;

    public function item_detail()
    {
        return $this->belongsTo('App\Item', 'design_code', 'design_code');
    }    

  public function info()
  {
    return $this->belongsTo('App\Purchaseorder','p_order_no','p_order_no');
  }

}
