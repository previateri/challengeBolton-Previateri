<?php

namespace Previateri\Bolton\Core;

use \Previateri\Bolton\Exceptions\HttpExceptions;

class Router
{

    private $router = [];

    public function add(string $method, string $pattern, $callback)
    {
        $method = strtolower($method);
        $pattern = '/^' .   str_replace('/' , '\/', $pattern) . '$/';
        $this->router[$method][$pattern] = $callback;
    }

    public function run()
    {
        $url = $this->getCurrentUrl();
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        if (empty($this->router[$method])) {
            throw new HttpExceptions('Method Not Especified.', 404);
        }

        foreach ($this->router[$method] as $route => $action) {
            
            if (preg_match($route, $url, $params)) {
                return $action($params);
            }
        }
        
        throw new HttpExceptions('Page Not Found.', 404);
    }

    public function getCurrentUrl()
    {
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        
        if (strlen($url) > 1){
            $url = rtrim($url, '/');
        }
        
        return $url;
    }
}