<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        $data = $request->toArray();
        $validator = Validator::make($data, User::rules());
        $status = 201;
        $response = null;
        if(!$validator->fails()){
            $data['password'] = bcrypt($data['password']);
            User::create($data);
            $response = 'success';
        }else{
            $status = 422;
            $response = $validator->errors()->toArray();
        }

        return response()->json(['message' => $response], $status);
    }
}
