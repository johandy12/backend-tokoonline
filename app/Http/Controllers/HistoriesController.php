<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Items;
use App\Cart;
use App\Histories;

class HistoriesController extends Controller
{
    public function __construct(){
      $this->middleware('auth:api');
    }
    
    public function index()
    {
      try {
        $data  = Histories::get();
        $array = Array();
        $array['data'] = $data;
      } catch (QueryException $a) {
        return response()->json(['error' => "failed"], 404);
      }

      if(count($data)>0){
        return response()->json($data);
      }return response()->json(['error' => 'not found'], 404);
    }

    public function history($id)
    {
      try {
        $conditons = ['accounts_id'=>$id];
        $data['data'] = Histories::with('items_src', 'cart_src')->where($conditons)->get();
      } catch (QueryException $e) {
        return response()->json(['error' => "failed"], 404);
      }

      if(count($data) > 0){
        return response()->json($data);
      }return response()->json(['error' => 'not found'], 404);
    }

    public function solditems($id)
    {
      try {
        $conditons = ['items_id'=>$id];
        $data['data'] = Histories::with('account_src', 'cart_src')->where($conditons)->get();
      } catch (QueryException $e) {
        return response()->json(['error' => "failed"], 404);
      }

      if(count($data) > 0){
        return response()->json($data);
      }return response()->json(['error' => 'not found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
      /*$add = [
        "accounts_id" => $request->$accounts_id,
        "items_id" => $request->items_id,
        "cart_id" => $request->cart_id,
        "total" => $request->total
      ];*/

      try{
        $history = new Histories();
        $history->accounts_id  = $request->accounts_id;
        $history->items_id     = $request->items_id;
        $history->cart_id      = $request->cart_id;
        $history->total        = $request->total;
        $history->save();
        $data = $history;
        $array = Array();
        $array['data'] = $data;
        return response()->json($data);
      }
      catch(QueryException $a){
        return response()->json(["Error" => "something missing"], 404);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      try{
        $data = Histories::where('id',$id)->delete();
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
}
