<?php

namespace Previateri\Bolton\Config\BdConfig;

use Previateri\Bolton\Config\Configs;


class BdConfig extends Configs
{
    private $params;
    
    public function __construct()
    {
        parent::__construct();
        $this->setParams();
    }

    public function getParams()
    {
        return $this->params;
    }

    private function setParams()
    {
        $params['development'] = [
            'dsn'           => 'mysql',
            'servername'    => 'localhost',
            'port'          => '8083',
            'username'      => 'root',
            'dbname'        => 'challengebolton_previateri',
            'password'      => 'rootpass',
        ];

        $params['production'] = [
            'dsn'           => 'mysql',
            'servername'    => 'localhost',
            'port'          => '8083',
            'username'      => 'root',
            'dbname'        => 'challengebolton_previateri',
            'password'      => 'rootpass',
        ];

        $params['test'] = [
            'dsn'           => 'mysql',
            'servername'    => 'localhost',
            'port'          => '8083',
            'username'      => 'root',
            'dbname'        => 'challengebolton_previateri',
            'password'      => 'rootpass',
        ];

        $environment = $this->getEnvironment();

        $this->params = $params[$environment];
    }

    protected function getEnvironment()
    {
        return parent::getEnvironment();
    }
}