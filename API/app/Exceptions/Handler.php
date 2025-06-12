<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    public function render(Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'error' => 'Erro de validação',
                'code' => 422,
                'errors' => $e->errors(),
            ], 422);
        }
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'error' => 'Recurso não encontrado.',
                'code' => 404,
            ], 404);
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'success' => false,
                'error' => 'Método HTTP não permitido.',
                'code' => 405,
            ], 405);
        }
        if ($e instanceof ThrottleRequestsException) {
            return response()->json([
                'success' => false,
                'error' => 'Limite de requisição excedido. Tente novamente mais tarde.',
                'code' => 429,
            ], 429);
        }
        if ($e instanceof AuthenticationException) {
            return response()->json([
                'success' => false,
                'error' => 'Não autenticado.',
                'code' => 401,
            ], 401);
        }
        if ($e instanceof HttpException) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage() ?: 'Ocorreu um erro interno.',
                'code' => $e->getStatusCode(),
            ], $e->getStatusCode());
        }
        if ($e instanceof Response) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => $e->getStatusCode(),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'code' => 500
        ], 500);
    }
}
