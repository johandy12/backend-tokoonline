<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends Controller
{      

    public function __construct(User $user){
      $this->user = $user;
      $this->middleware('auth:api', ['except' => ['index','register']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
          $data = User::get();
          $array = Array();
          $array['data'] = $data;
        } catch (QueryException $a) {
          return response()->json(['error' => "failed"], 404);
        }

        if(count($data)>0){
          return response()->json($data);
        }return response()->json(['error' => 'Nothing found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
      /*
        try{
        
            $user = new User();
            $user->email            = $request->email;
            $user->password         = $request->Hash::make($request->password);
            $user->name             = $request->name;
            $user->address          = $request->address;
            $user->phone            = $request->phone;
            $user->bank_account     = $request->bank_account;
            $user->save();
            return response()->json($user);

        }
        catch(QueryException $a){
            return response()->json(["Error" => "something missing"], 404);
        }
      */
        $new = [
          "email" => $request->email,
          "password" => Hash::make($request->password),
          "name" => $request->name,
          "address" => $request->address,
          "phone" => $request->phone,
          "bank_account" => $request->bank_account
        ];

        try{
          $data = $this->user->create($new);
          $array = Array();
          $array['data'] = $data;
          return response()->json($array);
        } catch(QueryException $a){
          return response()->json(["Error" => $a], 404);
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
        "email" => $request->email,
        "password" => Hash::make($request->password),
        "name" => $request->name,
        "address" => $request->address,
        "phone" => $request->phone,
        "bank_account" => $request->bank_account
      ];

      try{
        $data = User::where('id',$id)->update($new);
        $array = Array();
        $array['data'] = $data;
        return response()->json($array);
      }
      catch(QueryException $a){
        return response()->json(["Error" => "not found"], 404);
      }

      if($data = 1){
        return response()->json(["updated"],200);
      }
      else{
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
      $data = User::where("id",$id)->delete();

      if($data == 1){
        return response()->json(["deleted"],200);
      }
      else{
        return response()->json(["Error" => "not found"], 404);
      }
    }
}