<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $e
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        $code = 500;
        $result = ['message' => $e->getMessage()];

        if ($e instanceof ConnectionException) {
            $result = [
                'message' => 'Falha ao realizar requisição',
                'cause' => $e->getMessage(),
            ];
        }

        if ($e instanceof ValidationException) {
            $code = 422;
            $result = [
                'message' => "Erro nos dados enviados: {$e->getMessage()}",
                'errors' => $e->validator->errors()->toArray(),
            ];
        }

        if (
            $e instanceof NotFoundHttpException ||
            $e instanceof ModelNotFoundException
        ) {
            $code = 404;
            $result = ['message' => 'Recurso não encontrado'];
        }

        if (
            $e instanceof UnauthorizedException ||
            $e instanceof AuthorizationException ||
            $e instanceof AuthenticationException
        ) {
            $code = 401;
            $result = ['message' => $e->getMessage() ?: 'Sem autorização'];
        }

        if ($e instanceof QueryException) {
            $code = 500;
            $result = [
                'message' => "Não foi possível completar a consulta: {$e->getMessage()}",
            ];
        }

        $result['message'] = __($result['message']);

        return response()->json($result, $code);
    }
}
