<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeKey
{
    protected const AUTH_HEADER = 'X-Authorization';

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed|void
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $legis_key = static::getKey($request);

        if (self::envKeyExists() && self::isValidKey($legis_key)) {
            return $next($request);
        }

        throw new UnauthorizedException();
    }

    /**
     * @param Request $request
     * @return array|string|null
     * @throws Exception
     */
    protected static function getKey(Request $request)
    {
        if (! $legis_key = $request->header(self::AUTH_HEADER)) {
            throw new Exception(
                'Chave X-Authorization não encontrada no cabeçalho Authorization da requisição'
            );
        }

        return $legis_key;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected static function envKeyExists(): bool
    {
        if (! env('LEGIS_KEY')) {
            throw new Exception('Constante LEGIS_KEY não encontrada no arquivo .env');
        }

        return true;
    }

    /**
     * @param string $legis_key
     * @return bool
     * @throws Exception
     */
    public static function isValidKey(string $legis_key): bool
    {
        if ($legis_key !== env('LEGIS_KEY')) {
            throw new UnauthorizedException();
        }

        return true;
    }
}
