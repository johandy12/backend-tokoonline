<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Items;
use App\Cart;

class Histories extends Model
{
    //
	protected $table = 'histories';
    protected $fillable = ['accounts_id', 'items_id', 'cart_id', 'total'];

    public function items_src(){
      return $this->belongsTo("App\Items","items_id");
    }

  	public function cart_src(){
    	return $this->belongsTo("App\Cart","cart_id");
  	}
}
