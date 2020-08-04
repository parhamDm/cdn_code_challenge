<?php

namespace App\Http\Controllers;

use App\Code;
use App\Http\Resources\CodeResource;
use App\Http\Resources\Response;
use App\Http\Resources\ResponseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function is_winner(Request $request){
        //validation steps
        $response = new \stdClass();

        $validation = Validator::make($request->all(),[
            'number' => 'required',
            'code' => 'required',
        ]);
        if ($validation->fails()) {
            return new ResponseResource($validation->messages(),"-4","Invalid Input");

        }
        $winner=null;
        //database request
        try {
            $winner  = Code::where('value',$request->code)->first()->winners()->where('sender_number',$request->number)->first();
        }catch (\Throwable $ex){
            $response=new CodeResource([],"-2","Code Not found");
            return response()->json(($response), 404);        }
        if ($winner!=null){
            return new ResponseResource([],"0","Winner");
        }else{
            return new ResponseResource([],"1","Not Winner");
        }

    }
}
