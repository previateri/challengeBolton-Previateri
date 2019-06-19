<?php

namespace Previateri\Bolton\Core;

use \Previateri\Bolton\Exceptions\HttpExceptions;
/**
 * Class Router
 * Classe responsável por gerenciar as rotas e seus comportamentos.
 * A classe fornece o método para o registro de rotas e o de execução.
 */
class Router
{
    /**
     * Attribute $router
     * O atributo armazena as rotas que forem registradas
     */
    private $router = [];

    /**
     * Method add()
     * Método responsável pelo registro das rotas que estarão dentro do sistema.
     * O método manipula os parâmetros informados e adiciona a rota no attributo $router 
     * para ser verificado depois.
     * 
     * @param String $method O verbo http(GET, POST, DELETE, etc) da rota que será registrado
     * @param String $pattern O padrão de text que identificará a rota, regex são bem vindas.
     * @param Function $callback A função que será executada quando a rota for acionada,
     * podendo ser um método dentro de um controller.
     */
    public function add(String $method, String $pattern, $callback)
    {
        $method = strtolower($method);
        $pattern = '/^' .   str_replace('/' , '\/', $pattern) . '$/';
        $this->router[$method][$pattern] = $callback;
    }

    /**
     * Method run()
     * Responsável por executar o conteúdo da rota que esta sendo acessada no sistema.
     * A variável $url recebe o retorno do método getCurrentUrl(), a $method recebe do servidor
     * através da global $_SERVER['REQUEST_METHOD'] o nome do método que esta sendo utilizado na requisição.
     */
    public function run()
    {
        $url = $this->getCurrentUrl();
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        /** Caso o método utilizado na requisição não esteja registrado retorna uma excessão. */
        if (empty($this->router[$method])) {
            throw new HttpExceptions('Method Not Especified.', 404);
        }

        /** Para cada rota registrada com o método da requisição testa-se
         *  o padrão do nome da rota, caso encontre, retorna a ação e os parâmetros através
         * da função compact().  
         */
        foreach ($this->router[$method] as $route => $action) {
            if (preg_match($route, $url, $params)) {
                return compact('action', 'params');
            }
        }
        
        /**Caso nenhuma rota seja encontrada para o método da requisão, lança uma nova excessão */
        throw new HttpExceptions('Page Not Found.', 404);
    }

    /**
     * Method getCurrentUrl()
     * O método é responsável por recuperar a url atual da requisição através da
     * global $_SERVER['REQUEST_URI']. 
     * Após manipulação: setar / caso esteja vazia ou remover última barra caso esteja inserida;
     * o método retorna a url em forma de string.
     * @return String
     */
    private function getCurrentUrl()
    {
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        
        if (strlen($url) > 1){
            $url = rtrim($url, '/');
        }
        
        return $url;
    }
}