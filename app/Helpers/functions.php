<?php

use App\Models\ExceptionLog;
use App\Models\Permission;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

if (!function_exists('apiResponse')) {
    /**
     * upload image in specific directory "storage"
     * @param $success
     * @param $message
     * @param null $data
     * @return json
     */
    function apiResponse($success, $message, $statusCode, $data = null)
    {
        $response =  [
            'success' => $success,
            'message' => $message,
            'data' => $data ,
        ];


        return response()->json($response,$statusCode);
    }
}



