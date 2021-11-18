<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    /**
     * @var mixed|string
     */
    protected $info;

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($info, $message = '', $code = 500, Throwable $previous = null)
    {
        $this->info = $info;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed|string
     */
    public function getInfo()
    {
        return $this->info;
    }
}
