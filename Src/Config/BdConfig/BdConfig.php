<?php

namespace Previateri\Bolton\Config\BdConfig;

use Previateri\Bolton\Config\Configs;

/**
 * Class BdConfig
 * Responsável por setar as configurações de conexão com o banco de dados.
 * Os parâmetros são setados através do atributo $params que pode receber
 * as configurações de diversos ambientes.
 * A classe extende da super classe Configs.
 */
class BdConfig extends Configs
{

    private $params;
    
    public function __construct()
    {
        parent::__construct();
        $this->setParams();
    }

    /**
     * Method getParams()
     * Método responsável por retornar os valores que foram armazenados no atributo
     * $params
     * @return Array $param
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Method setParams()
     * Método utilizado para registrar os parâmetros que serão utilizados
     * para a realização da conexão com o banco de dados.
     * Cada ambiente deve ser registrado dentro do índice correspondente do array $params.
     * A variável $environment é setada com o retorno do método getEnvironment().
     * O atributo $params em seguida é setado levando em consideração o ambiente em que o sistema
     * esta sendo executado, armazenado na variável $environment.
     */
    private function setParams()
    {
        $params['development'] = [
            'dsn'           => 'mysql',
            'servername'    => 'mysql',
            'port'          => '3306',
            'username'      => 'root',
            'dbname'        => 'challenge_bolton_previateri',
            'password'      => 'rootpass',
            'unix_socket' => '/tmp/mysql.sock',
        ];

        $params['production'] = [
            'dsn'           => '',
            'servername'    => '',
            'port'          => '',
            'username'      => '',
            'dbname'        => '',
            'password'      => '',
        ];

        $params['test'] = [
            'dsn'           => 'mysql',
            'servername'    => 'localhost',
            'port'          => '8083',
            'username'      => 'root',
            'dbname'        => 'challenge_bolton_previateri',
            'password'      => 'rootpass',
        ];

        $environment = $this->getEnvironment();

        $this->params = $params[$environment];
    }

    /**
     * Method getEnvironment
     * Utiliza o método getnEnviroment() da classe pai para recuperar o valor
     * correspondente ao ambiente em que o sistema esta sendo executado
     * @return String
     */
    protected function getEnvironment()
    {
        return parent::getEnvironment();
    }
}