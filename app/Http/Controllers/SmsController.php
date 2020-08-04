<?php

namespace App\Http\Controllers;

use App\Http\Resources\CodeResource;
use App\Http\Resources\Response;
use App\Http\Resources\ResponseResource;
use App\Jobs\ProcessSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class SmsController extends Controller
{
    public function receive(Request $request){
        $validation = Validator::make($request->all(),[
            'phone' => 'required|regex:/^09\d{9}$/',
            'code' => 'required|min:6|max:6',
        ]);


        if ($validation->fails()) {
            return new ResponseResource($validation->messages(),"-4","Invalid Input");
        }
        //send to queue
        ProcessSms::dispatch($request->code,$request->phone,new \DateTime());

        return new ResponseResource($validation->messages(),"0","SUCCESS");
    }
}
