<?php

namespace Previateri\Bolton\Core;

/**
 * Class Response
 * A classe é reponsável por executar a ação atrelada a rota e retornar todas
 * as respostas em formato json.
 * O seu único método __invoke() é executado diretamente quando a classe é chamada.
 * Os parâmetros $action e $params correspondem ao Controller e Méthodo 
 * desse Controller, respectivamente.
 */
class Response
{
    public function __invoke($action, $params)
    {
        /**
         * Testa se a ação da rota corresponde a uma string e a separa
         * para determinar o Controller e os Métodos.
         */
        if (is_string($action)) {
            $action = explode("::", $action);
            /** Intancia um novo objeto do controller declarado na rota. */
            $action[0] = new $action[0];
        }

        /** 
         * Armazena na variável $response o resultado do método invocado do controller.
         * Por padrão, todos os métodos irão retornar um array contendo uma chave e um
         * valor que será convertido para json.
         */
       $response = call_user_func_array($action, $params);
       
       /**
        * Garante que todos os retornos sejam feitos através de json.
        */
       if (is_array($response)) {
           $response = json_encode($response, true);
       } else {
           $response = null;
       }

       echo $response;
    }
}