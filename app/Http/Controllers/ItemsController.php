<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Items;

class ItemsController extends Controller
{
    public function __construct(Items $item){
      $this->item = $item;
      $this->middleware('auth:api', ['except' => ['get']]);
    }

    public function get()
    {
      try {
        $data  = Items::get();
        $array = Array();
        $array['data'] = $data;
      } catch (QueryException $a) {
        return response()->json(['error' => "failed"], 404);
      }

      if(count($data)>0){
        return response()->json($array);
      }return response()->json(['error' => 'not found'], 404);
    }

    public function getItems($id)
    {
      try {
        $data  = Items::where('accounts_id',$id)->get();
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
      // $new = [
      //   //'accounts_id' => User::find($request->accounts_id),
      //   'accounts_id' => $request->accounts_id,
      //   'name' => $request->name, 
      //   'category' => $request->category,
      //   'stock' => $request->stock,
      //   'price' => $request->price,
      //   'desc' => $request->desc
      // ];

      try{
        $item = new Items();
        $item->accounts_id  = $id;
        $item->category_id  = $request->category_id;
        $item->name         = $request->name;
        $item->stock        = $request->stock;
        $item->price        = $request->price;
        $item->desc         = $request->desc;
        $item->save();
        $data = $item;
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
        'price' => $request->price,
        'desc' => $request->desc
      ];

      $pt = $request->id;

      $data = Items::where('id',$pt)->update($new);

      if($data == 1){
        return response()->json(["updated"],200);
      }
      
      else{
        return response()->json(["Error" => "not found"], 404);
      }
    }

    public function searchI(Request $request)
    {
        // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        $error = ['error' => 'No results found, please try with different keywords.'];
        // Making sure the user entered a keyword.
        if($request->has('q')) {
            // Using the Laravel Scout syntax to search the products table.
            $posts = Category::with('items')->where('name', "like", $s)->get();
            // If there are results return them, if none, return the error message.
            return $posts->count() ? $posts : $error;
        }
        // Return the error message if no keywords existed
        return $error;
    }

    public function searchC($s)
    {
      $search = '%'.$s.'%';
      try {
        $data = Category::where("category","like",$s)->get();
      } catch (QueryException $e) {
        return response()->json(['error' => "..."], 404);
      }

      if(count($data)>0){
        return response()->json($data);
      }return response()->json(['error' => 'Nothing found'], 404);
    }

    public function delete($id)
    {
      try{
        $data = Items::where('id',$id)->delete();
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