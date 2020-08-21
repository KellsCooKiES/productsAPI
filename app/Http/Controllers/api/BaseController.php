<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller as Controller;
class BaseController extends Controller
{
    /**
     * Success response method.
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    public function sendResponse($result,$message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    /**
     * Return error response.
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }


}
