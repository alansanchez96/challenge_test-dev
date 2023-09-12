<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

trait JsonResponseService
{
    public function jsonSuccess(string $action, mixed $value = null): JsonResponse
    {
        $data = [
            'message' => "Se ha {$action} satisfactoriamente.",
            ($value === null) ?: 'data' => $value,
        ];

        return response()
            ->json(array_filter($data), Response::HTTP_OK);
    }

    public function jsonFailure(string $message): JsonResponse
    {
        Log::error('error: ' . $message);

        return response()
            ->json(['error' => 'Ha ocurrido un error'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
