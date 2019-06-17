<?php

namespace Previateri\Bolton\Config;

abstract class Configs
{
    private $configType;
    private $arrayConfig;
    private $environment;

    protected function __construct()
    {
        $this->setEnvironment();
        //var_dump($this->environment['environment']); die;
    }

    private function setEnvironment()
    {
        if (!$this->checkEnvironment()) {
            #ToDo -> implementar erro de ambiente
            die('erro de ambiente');
        }
        
    }

    protected function getEnvironment()
    {
        return $this->environment['environment'];
    }

    private function checkEnvironment()
    {
      
        $fileEnvironment = dirname(dirname(__DIR__)) . '/.env';

        if (!file_exists($fileEnvironment)) {
            return false;
        }

        $this->environment = parse_ini_file($fileEnvironment);

        if (empty($this->environment)) {
            return false;
        }

        if (in_array($this->environment['environment'], ['development', 'test', 'production'])) {
            return true;
        }

        return false;
    }

} 