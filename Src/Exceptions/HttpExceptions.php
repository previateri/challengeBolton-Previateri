<?php

namespace Previateri\Bolton\Exceptions;

/**
 * Class HttpExceptions
 * Responsável por lançar Exceptions customizadas para erro de rotas  no sistema.
 * A classe captura os erros lançados e envia para o construtor da classe Exceptions do PHP. 
 */
class HttpExceptions extends \Exception
{
    public function __construct(string $message, int $code, \Exception $previous = null)
    {
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}