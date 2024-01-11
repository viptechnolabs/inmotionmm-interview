<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    protected function success($data = null, string $message = null, int $status = 200, bool $statusCode = true): JsonResponse
    {
        $status = ($status === 0) ? 200 : $status;

        return $this->jsonResponse($data, $message, $status);
    }

    private function jsonResponse($data, string $message = null, int $code = 200, bool $statusCode = true): JsonResponse
    {
        $response = [
            //'data' => $data,
            'message' => $message,
            'status' => $code === 200
        ];
        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    protected function error(string $message, int $status = 422, bool $statusCode = true): JsonResponse
    {
        $status = ($status === 0) ? 422 : $status;

        return $this->jsonResponse(null, $message, $status, $statusCode);
    }
}
