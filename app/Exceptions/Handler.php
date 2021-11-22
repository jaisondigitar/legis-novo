<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
        /*$code = 500;

        $result = [
            'errors' => $e->getMessage(),
        ];

        if ($e instanceof ConnectionException) {
            $result = [
                'errors' => [
                    'errors' => 'Falha ao realizar requisição',
                    'message' => $e->getMessage(),
                ],
            ];

            return response()->view('common.errors', $result, $e->getCode());
        }

        if ($e instanceof ValidationException) {
            $code = 422;

            $result = [
                'errors' => [
                    'errors' => $e->validator->errors()->toArray(),
                    'message' => "Erro nos dados enviados: {$e->getMessage()}",
                ],
            ];

            return response()->view('common.errors', $result, $code);
        }

        if (
            $e instanceof NotFoundHttpException ||
            $e instanceof ModelNotFoundException
        ) {
            $code = 404;

            $result = [
                'errors' => 'Recurso não encontrado.',
            ];

            return response()->view('common.errors', $result, $code);
        }

        if (
            $e instanceof UnauthorizedException ||
            $e instanceof AuthorizationException ||
            $e instanceof AuthenticationException
        ) {
            $code = 401;

            $result = [
                'errors' => $e->getMessage() ?: 'Sem autorização.',
            ];

            return response()->view('common.errors', $result, $code);
        }

        if ($e instanceof QueryException) {
            $code = 500;

            $result = [
                'errors' => "Não foi possível completar ação: {$e->getMessage()}",
            ];

            return response()->view('common.errors', $result, $code);
        }

        $result['message'] = __($result['message']);*/

        return parent::render($request, $e);
    }
}
