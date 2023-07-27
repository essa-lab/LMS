<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    //
    public function sendResponse($data,$message = null,$statusCode=Response::HTTP_OK){
        $response=[
            "data"=>$data,
        ];
        if ($message != null){
            $response = [
                "data"=>$data,
                "message"=>$message,
            ];      
        }  
        
        return response()->json($response,$statusCode);
    }
    public function sendError($message,$errors=[],$statusCode){
        $response = [
            "message"=>$message,
            "erros"=>$errors,
        ];
        return response()->json($response,$statusCode);
    }
}
