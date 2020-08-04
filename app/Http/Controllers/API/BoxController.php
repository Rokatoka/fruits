<?php

namespace App\Http\Controllers\API;

use App\Box;
use App\Fruit;
use App\Http\Controllers\Controller;
use App\UserBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BoxController extends Controller
{
    public function getList(Request $request){
        return response()->json(['data' => Box::with('fruit')->paginate(3)], 200);
    }

    public function create(Request $request){
        $data = $request->toArray();
        $validator = Validator::make($data, Box::rules());
        $status = 201;
        $response = null;
        if(!$validator->fails()){
            $data['current_volume'] = 0;
            $id = isset($data['id']) ? $data['id'] : 0;
            Box::updateOrCreate(['id' => $id], $data);
            $response = 'success';
        }else{
            $status = 422;
            $response = $validator->errors()->toArray();
        }

        return response()->json(['message' => $response], $status);
    }

    public function delete($id){
        try{
            $box = Box::find($id);
            $box->delete();
            $message = 'deleted';
            $status = 200;
        }catch(\Exception $e){
            Log::error($e);
            $message = 'no data';
            $status = 204;
        }
        return response()->json(['message' => $message], $status);
    }

    public function makeApplication(Request $request){
        $data = $request->toArray();
        $rules = [
            'volume' => 'required|numeric|min:1',
            'fruit_id' => 'required|numeric|min:1',
        ];
        $validator = Validator::make($data, $rules);
        $status = 201;
        if(!$validator->fails()){
            $box = Box::where('fruit_id', $data['fruit_id'])->get();
            $response = 'no free box';
            foreach($box as $b){
                if(($b->current_volume + $data['volume'] <= $b->max_volume)){
                    $b->current_volume = $b->current_volume + $data['volume'];
                    $b->save();

                    UserBox::create([
                        'user_id' => $data['user_id'],
                        'box_id' => $b->id
                    ]);
                    $response = $b;
                    break;
                }
            }
        }else{
            $status = 422;
            $response = $validator->errors()->toArray();
        }

        return response()->json(['message' => $response], $status);

    }

    public function getUserBoxes($user_id){
        $boxes = Box::whereHas('users', function ($q) use($user_id){
            $q->where('user_id', $user_id);
        })->with('fruit')->get();
        return response()->json(['data' => $boxes], 200);
    }

    public function getFruits(){
        return response()->json(['data' => Fruit::all()], 200);
    }
}
