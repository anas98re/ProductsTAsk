<?php

namespace App\Services;

use App\Http\Controllers\Controller;

class JsonResponeService extends Controller
{

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function sendForbiddenResponse( $message)
    {
        $response = [
            'success' => false,
            'message' => $message
        ];
        return response()->json($response, 403);
    }


    public function sendEmptyResponse($message)
    {
        $response = [
            'success' => true,
            'data' => [],
            'message' => $message
        ];

        return response()->json($response, 204);
    }

    public function sendError($error, $errorMessage = [], $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];
        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }

    public function sendSucssas($result)
        {
            $response = [
                'result' => 'success',
                'code' => 200,
                'message' => $result
            ];
            return response()->json($response, 200);
        }

    public function sendUnauthenticated($error, $errorMessage = [], $code = 401)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];
        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }
}
