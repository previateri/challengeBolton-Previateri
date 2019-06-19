<?php

namespace Previateri\Bolton\Exceptions;

/**
 * Class DatabaseExceptions
 * Responsável por tratar Exceptions relacionada ao banco de dados, a classe captura
 * os erros lançados e envia para o construtor da classe Exceptions do PHP. 
 */
class DatabaseExceptions extends \Exception
{
    public function __construct(string $message, int $code, \Exception $previous = null)
    {
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}