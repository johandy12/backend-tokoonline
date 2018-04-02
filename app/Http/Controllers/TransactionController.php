<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class TransactionController extends Controller
{
    public function __construct(Transaction $transaction){
      $this->transaction = $transaction;
      $this->middleware('auth:api');
    }

    public function index()
    {
      try {
        $data  = Transaction::get();
        $array = Array();
        $array['data'] = $data;
      } catch (QueryException $a) {
        return response()->json(['error' => "failed"], 404);
      }

      if(count($data)>0){
        return response()->json($data);
      }return response()->json(['error' => 'not found'], 404);
    }

    public function get($id)
    {
      try {
        $data  = Transaction::where('accounts_id',$id)->get();
        $array = Array();
        $array['data'] = $data;
      } catch (QueryException $e) {
        return response()->json(['error' => "failed"], 404);
      }

      if(count($data) > 0){
        return response()->json($array);
      }return response()->json(['error' => 'not found'], 404);
    }

    public function add($id, Request $request)
    {
      try{
        $transaction = new Transaction();
        $transaction->name         = $request->name;
        $transaction->stock        = $request->stock;
        $transaction->price        = $request->price;
        $transaction->save();
        $data = $transaction;
        $array = Array();
        $array['data'] = $data;
        return response()->json($array, 200);
      } catch(QueryException $a){
        return response()->json(["Error" => "something missing"], 404);
      }
    }

    public function update($id, Request $request)
    {
      $new = [
        'name' => $request->name, 
        'stock' => $request->stock,
        'price' => $request->price
      ];

      $pt = $request->id;

      $data = Transaction::where('id',$pt)->update($new);

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
        $data = Transaction::where('id',$id)->delete();
      } catch(QueryException $a){
        return response()->json(["Error" => "not found"], 404);
      }

      if($data == 1){
        return response()->json(["deleted"],200);
      }
      else{
        return response()->json(["Error" => "not found"], 404);
      }
    }
}
}
