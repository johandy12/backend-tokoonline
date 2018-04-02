<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
	protected $table = 'cart';
    protected $fillable = ['item_id', 'qty'];

  	public function item_src(){
    	return $this->belongsTo("App\Items", "item_id");
  	}
}
