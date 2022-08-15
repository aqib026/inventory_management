<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbayTemplate extends Model
{
	protected $fillable = ['template_name','item_description'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
