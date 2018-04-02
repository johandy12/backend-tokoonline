<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
  	public function __construct(Category $category){
    	$this->category = $category;
  	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      	try {
        	$data  = $this->category->get();
        	$array = Array();
        	$array['data'] = $data;
      	} catch (QueryException $e) {
        	return response()->json(['error' => "Nothing found"], 404);
      	}

	    if(count($data)>0){
        	return response()->json($array);
      	}	return response()->json(['error' => 'Nothing found'], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
      try {
        $data = $this->category->where("id",$id)->get();
       	$array = Array();
        $array['data'] = $data;
      } catch (QueryException $e) {
        return response()->json(['error' => "Nothing found"], 404);
      }

      if(count($data)>0){
        return response()->json($array);
      }return response()->json(['error' => 'Nothing found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
      	try{
        	$category = new Category();
        	$category->category = $request->category;
	        $category->save();
        	$data = $category;
        	$array = Array();
        	$array['data'] = $data;
        	return response()->json($category);
      	}	catch(QueryException $a){
        	return response()->json(["Error" => "Failed"], 404);
      	}
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
      	$new = [
        	"category" => $request->category
      	];

      	try{
        	$this->category->where('id',$id)->update($new);
      	}	catch(QueryException $a){
        	return response()->json(["Error" => "not found"], 404);
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
        $data = $this->category->where("id",$id)->delete();
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
	