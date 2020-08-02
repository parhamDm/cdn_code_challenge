<?php

namespace App\Http\Controllers;

use App\Http\Resources\Response;
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
        $response = new stdClass();

        if ($validation->fails()) {
            $response->status_code = "1";
            $response->status_msg = $validation->messages();
            return new Response($response);
        }
        //send to queue
        ProcessSms::dispatch($request->code,$request->phone,new \DateTime());

        $response->status_msg = "SUCCESS";
        $response->status_code = "0";
        return new Response($response);
    }
}
