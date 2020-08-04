<?php

namespace App\Http\Controllers;

use App\Code;
use App\Http\Resources\CodeResource;
use App\Http\Resources\CodesCollection;
use App\Winner;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    public function index(Request $request){
        //handle page size
        $max_page_size =env('MAX_PAGE_SIZE','1000');
        if($request->limit&&$request->limit<$max_page_size&&$request->limit>0){
            $max_page_size = $request->limit;
        }
        //check verbose
        if((boolean)$request->verbose&&$request->verbose=="true"){
            $select_array=['sender_number','date'];
        }else{
            $select_array=['sender_number'];
        }
        try {
            $winners = (Code::find($request->code)->winners()->paginate($max_page_size,$select_array));
        }catch (\Throwable $ex){
            $response=new CodeResource([],"-2","Not found");
            return response()->json(($response), 404);
        }
        $winners->appends(request()->query());
        return new CodesCollection($winners,"0","SUCCESS");
    }

}
