<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public $timestamps = false;
    public $primaryKey = 'cat_id';

    public function ebayCategory(){
    	return $this->hasOne('App\EbayHawaCat','hawavee_id','cat_id');
    }

    public function child(){
    	return $this->hasMany('App\Category','cat_parent');
    }

    public function parent(){
    	return $this->belongsTo('App\Category','cat_parent');
    }

}
