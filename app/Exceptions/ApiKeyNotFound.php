<?php

namespace App\Exceptions;

use Throwable;

class ApiKeyNotFound extends BaseException
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code = , Throwable $previous = null)
    {
        $code = ExceptionCodes::CREATE_SUBSCRIPTION_ERROR;
        $info = ExceptionCodes::$error_messages[ExceptionCodes::CREATE_SUBSCRIPTION_ERROR];

        parent::__construct($info, $message, $code, $previous);
    }
}
