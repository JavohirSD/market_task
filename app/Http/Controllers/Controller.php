<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Return success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function success(mixed $data, string $message = "", int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success'    => true,
            'data'       => $data,
            'message'    => $message,
        ], $code);
    }


    /**
     * Return error response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function error(mixed $data, string $message = "", int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success'    => false,
            'data'       => $data,
            'message'    => $message,
        ], $code);
    }
}
