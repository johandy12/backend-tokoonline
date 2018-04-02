<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Cart;
use App\Items;
use Illuminate\Database\QueryException;

class CartController extends Controller
{
    // 
    public function __construct(){
      $this->middleware('auth:api', ['except' => ['index']]);
    }

    
    public function index(Request $request)
    {
      /*
        $data  = Items::where('id',$request->items_id)->get();
        $data[0]->item_src;
        $array = Array();
        $array['data'] = $data[0];
        return response()->json($array);
      */
      try {
        $data  = Items::where('items_id', 'items_id')get();
        $array = Array();
        $array['data'] = $data;
        return response()->json($array);
      } catch (QueryException $a) {
        return response()->json(['error' => "failed"], 404);
      }

      if(count($data)>0){
        return response()->json($data);
      }return response()->json(['error' => 'not found'], 404);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function calculate(Request $request)
    {

      $stk = Items::select('stock')->where('id',$request->item_id)->get();
      $stock = 0;
      foreach ($stk as $key => $value) {
          $stock = $value["stock"];
      }
      if($request->qty > $stock){
          return response()->json(["Error" => "not enough stock"], 404);
      }

      $prc = Items::select('price')->where('id',$request->item_id)->get();
      $price = 0;
      foreach ($prc as $key => $value) {
          $price = $value["price"];
      }

      $res = $request->qty * $price;
      $remain = $stock-$request->qty;

      try{
          $cart = new Cart();
          $cart->items_id  = $request->items_id;
          $cart->qty       = $request->qty;
          $cart->total     = $request->res;
          $item->save();
          $data = $item;
          $array = Array();
          $array['data'] = $data;
          Items::where('id',$request->item_id)->update(array('stock' => $remain));
          return response()->json($data);
      } catch(QueryException $a){
          return response()->json(["Error" => $a], 404);
      }
    }
    */
    
    public function add($id)
    {
      try{
          $cart = new Cart();
          $cart->items_id  = $id;
          $cart->qty       = 1;
          $cart->save();
          $data = $cart;
          $array = Array();
          $array['data'] = $data;

          return response()->json($array);
      } catch(QueryException $a){
          return response()->json(["Error" => "error"], 404);
      }
    }

    public function update($id, Request $request)
    {
      $new = [
        'qty' => $request->qty
      ];

      $pt = $request->id;

      Cart::where('id',$pt)->update($new);

      if($data == 1){
        return response()->json(["updated"],200);
      }
      
      else{
        return response()->json(["Error" => "not found"], 404);
      }
    }

    public function delete($id)
    {
      try{
        $data = Cart::where('id',$id)->delete();
      }
      catch(QueryException $a){
        return response()->json(["Error" => "not found"], 404);
      }

      if($data == 1){
        return response()->json(["deleted"],200);
      }
      else{
        return response()->json(["Error" => "not found"], 404);
      }
    }

    public function deleteAll()
    {
      try{
        $data = Cart::delete();
      }
      catch(QueryException $a){
        return response()->json(["Error" => "not found"], 404);
      }

      if($data >= 1){
        return response()->json(["deleted"],200);
      }
      else{
        return response()->json(["Error" => "not found"], 404);
      }
    }

    public function showAll(){
    
      $cart=Cart::join('item_src', 'carts.items_id','=','items.id')
         ->select('items.*')
         ->get();
      $array = Array();
      $array['data'] = $cart;
      if(count($cart) > 0)
        return response()->json($array, 200);
      return response()->json(['error' => 'cart not found'], 404);
    }
}
