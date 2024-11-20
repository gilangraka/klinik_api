<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message = 'success')
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendError($errorMessage, $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $errorMessage,
            'data'    => null,
        ];
        return response()->json($response, $code);
    }
}
