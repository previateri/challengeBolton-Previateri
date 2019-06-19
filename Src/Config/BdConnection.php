<?php

namespace Previateri\Bolton\Config;

use Previateri\Bolton\Config\BdConfig\BdConfig;
use \Previateri\Bolton\Exceptions\DatabaseExceptions;
use \Pdo;

/**
 * Class BdConnection
 * Classe responsável por realizar a conexão com o banco de dados. A classe utiliza 
 * a extensão PDO e trabalha com o padrão Singleton.
 */
class BdConnection
{
    
    private static $instance = null;
    private $db;
    private $params;

    /** Mehtod __construct()
     *  Ao ser intanciada a classe carrega uma nova instância da BdConfig e em seguida
     *  armazena os parâmetros necessários para a conexão na variável $fileConfig.
     *  A variável $stringPdo é montada a partir das configurações e utilizada para 
     *  intanciar um novo objeto da extensão PDO no atributo $db.
     */
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
        //Protege a classe de ser clonada.
    }

    private function __wakeup() {
        //Protege a classe de ser chamada atravpes do método mágico. 
    }

    /**
     * Method getInstance()
     * Verifica se já existe um objeto da classe intanciado.
     * Caso exista retorna a mesma instância, caso não, cria-se uma nova instância.
     * @return Object $instance
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new BdConnection;
        }

        return self::$instance;
    }

    /**
     * Method getDB
     * Retorna a conexão criada na construção da classe através da
     * extensão do PDO que esta armazenada no atributo $db.
     * @return Object $db
     */
    public function getDb()
    {
        return $this->db;
    }
}