<?php

namespace Previateri\Bolton\Config;

use Previateri\Bolton\Config\BdConfig\BdConfig;
use \Previateri\Bolton\Exceptions\DatabaseExceptions;
use \Pdo;

class BdConnection
{
    
    private static $instance = null;
    private $db;
    private $params;

    private function __construct()
    {
       
        $fileConfig = new BdConfig;
        $fileConfig = $fileConfig->getParams();
        
        $stringPdo  = $fileConfig['dsn'] . ':host=' . $fileConfig['servername'] . ';dbname=' . $fileConfig['dbname'] .  ';port=' . $fileConfig['port'] . ';charset=utf8';
        
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        
        try {
            $this->db =  new PDO($stringPdo, $fileConfig['username'], $fileConfig['password'], $default_options);
        } catch (\PDOException $e) {
            throw new DatabaseExceptions($e->getMessage(), $e->getCode());
        }
        
    }

    private function __clone()
    {
        //Desabilita a possibilidade da classe ser clonada
    }

    private function __wakeup() {
        #ToDo: Escrever melhor aqui
        //Desabilida a possibilidade da classe ser wakeada? 
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new BdConnection;
        }

        return self::$instance;
    }

    public function getDb()
    {
        return $this->db;
    }

}