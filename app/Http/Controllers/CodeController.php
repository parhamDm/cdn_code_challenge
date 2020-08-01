<?php

namespace App\Http\Controllers;

use App\Code;
use App\Http\Resources\CodesCollection;
use App\Http\Resources\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class CodeController extends Controller
{
    public function index(){
        return new CodesCollection(Code::paginate(10));
    }


    public function create(Request $request){
        //validation step
        $validation = Validator::make($request->all(),[
            'request_limit' => 'required',
        ]);
        if ($validation->fails()) {
            $response = new stdClass();
            $response->status_code = "1";
            $response->status_msg = $validation->messages();
            return new Response($response);
        }
        //generate code
        $code  =new Code();
        do{
            $code->value = substr(md5(uniqid(rand(), true)),0,6);
            $valid = Code::where('value',$code->value)->first();
        }while($valid);
        $code->request_limit = $request->request_limit;
        //save db
        $code->save();
        //return result
        $response = new stdClass();
        $response->status_msg = "SUCCESS";
        $response->status_code = "0";
        return new Response($response);
    }


}
