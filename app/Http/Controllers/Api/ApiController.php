<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function apiResponse($data,$message=null,$code=200)
    {
        $response = [
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response,$code);
    }
}
