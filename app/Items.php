<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Histories;
use App\Cart;

class Items extends Model
{
    //
	protected $table = 'items';
    protected $fillable = ['name', 'stock', 'price', 'desc', 'account_id', 'category_id'];
    protected $hidden = ['remember_token', 'created_at', 'updated_at'];

    public function categories(){
        return $this->belongsTo("App\Category", "category_id");
    }

  	public function seller_src(){
    	return $this->belongsTo("App\User", "account_id");
  	}

    public function cart_src(){
    	return $this->hasMany("App\Cart");
    }

    public function itemhistory_src(){
    	return $this->hasMany("App\Histories");
    }
}
