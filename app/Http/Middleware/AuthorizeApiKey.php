<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeApiKey
{
    protected const AUTH_HEADER = 'X-Authorization';

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed|void
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $api_key = self::getApiKey($request);

            if (self::envKeyExists() && self::isValidKey($api_key)) {
                return $next($request);
            }

            self::error401();
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @return array|string|null
     * @throws Exception
     */
    protected static function getApiKey(Request $request)
    {
        if (! $api_key = $request->header(self::AUTH_HEADER)) {
            throw new Exception(
                'Chave X-Authorization não encontrada no cabeçalho Authorization da requisição',
                403
            );
        }

        return $api_key;
    }

    public static function envKeyExists()
    {
        if (! env('API_KEY')) {
            throw new Exception('Constante API_KEY não encontrada no arquivo .env', 403);
        }

        return true;
    }

    public static function isValidKey(string $api_key)
    {
        if (! ($api_key === env('API_KEY'))) {
            self::error401();
        }

        return true;
    }

    public static function error401()
    {
        throw new Exception('Não autorizado', 401);
    }
}
