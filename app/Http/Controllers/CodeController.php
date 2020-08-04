<?php

namespace App\Http\Controllers;

use App\Code;
use App\Http\Resources\CodeResource;
use App\Http\Resources\CodesCollection;
use App\Http\Resources\Response;
use App\Http\Resources\ResponseCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class CodeController extends Controller
{
    public function index(Request $request){
        $max_page_size =env('MAX_PAGE_SIZE','1000');
        if($request->limit&&$request->limit<$max_page_size&&$request->limit>0){
            $max_page_size = $request->limit;
        }
        $codes = Code::paginate($max_page_size);
        $codes->appends(request()->query());
        return new CodesCollection($codes,"0","SUCCESS");
    }

    public function show(Request $request){
        //validate
        if(!$request->code||!is_numeric($request->code)){
            return new CodeResource([],"-2","Invalid id");
        }
        //db
        $code_details=Code::find($request->code);
        if (!$code_details){
                $response=new CodeResource([],"-3","Not found");
            return response()->json(($response), 404);
        }
        return new CodeResource($code_details,"0","SUCCESS");
    }


    public function store(Request $request){
        //validation step
        $validation = Validator::make($request->all(),[
            'request_limit' => 'required|numeric|max:1000000|min:1',
        ]);
        if ($validation->fails()) {

            return new CodeResource($validation->messages(),"-4","Invalid Input");
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

        return new CodeResource($code,"0","Success");
    }

    public function destroy($id){
        Code::destroy($id);
        return new CodeResource([],"0","Success");
    }
}
