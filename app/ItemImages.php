<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemImages extends Model
{
    
   protected $table = 'item_images';
   public $primaryKey = 'image_id';
	public $timestamps = false;     	
}
