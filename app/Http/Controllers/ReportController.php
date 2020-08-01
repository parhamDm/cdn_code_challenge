<?php

namespace App\Http\Controllers;

use App\Code;
use App\Http\Resources\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function isWinner(Request $request){
        //validation steps
        $response = new \stdClass();

        $validation = Validator::make($request->all(),[
            'number' => 'required',
            'code' => 'required',
        ]);
        if ($validation->fails()) {
            $response->status_code = "-1";
            $response->status_msg = $validation->messages();
            return new Response($response);
        }
        //
        $winner = Code::where('value',$request->code)->first()->winners()->where('sender_number',$request->number)->first();
        if ($winner!=null){
            $response->status_code = "0";
            $response->status_msg = "IS_WINNER";
        }else{
            $response->status_code = "1";
            $response->status_msg = "NOT WINNER";
        }
        return new Response($response);

    }
}
