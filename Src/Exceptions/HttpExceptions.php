<?php

namespace Previateri\Bolton\Exceptions;

class HttpExceptions extends \Exception
{
    public function __construct(string $message, int $code, \Exception $previous = null)
    {
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}