<?php

namespace Previateri\Bolton\Config;

/**
 * Abstract Class Configs
 * A classe é responsável por fornecer métodos e atributos as classes filhas que
 * irão carregar diversas configurações para o sistena de acordo com o ambiente 
 * em que o mesmo esta sendo executado.
 */
abstract class Configs
{
    private $configType;
    private $arrayConfig;
    private $environment;

    /**
     * Ao ser intanciado a classe automaticamente seta o ambiente que será
     * utilizado durante a execuçao do sistema.
     */
    protected function __construct()
    {
        $this->setEnvironment();
    }

    /**
     * Method setEnvironment()
     * Invoca o método checkEnvironment() e a partir do seu retorno
     * interrompe a execução do sistema, caso o set do ambiente seja
     * inválido.
     */
    private function setEnvironment()
    {
        if (!$this->checkEnvironment()) {
            #ToDo -> implementar erro de ambiente
            die('O ambiente carregado não é esperado.');
        }
        
    }

    /**
     * Method getEnvironment()
     * Responsável por retornar para as classes filhas o ambiente
     * carregado no parâmetro $environment.
     * @return String
     */
    protected function getEnvironment()
    {
        return $this->environment['environment'];
    }

    /**
     * Method checkEnvironment()
     * O Método responsável por carregar o arquivo .env localizado na raiz do projeto. O arquivo
     * deve conter a declaração do ambiente em quem o sistema esta rodando.
     * @return Bollean
     */
    private function checkEnvironment()
    {
        /** Seta na variável $fileEnvironment o caminho do arquivo .env */
        $fileEnvironment = dirname(dirname(__DIR__)) . '/.env';
        
        /** Verifica se o arquivo existe, caso contrário retorna false. */
        if (!file_exists($fileEnvironment)) {
            return false;
        }

        /** Realiza o parse do conteúdo do arquivo para o atributo $environment. */
        $this->environment = parse_ini_file($fileEnvironment);

        /** Verifica se houve o parse do arquivo .env para o atributo e se ele não esta vazio. */
        if (empty($this->environment)) {
            return false;
        }

        /** Verifica se o valor carregado no atributo esta dentro dos valores registrados e aceitáveis. */
        if (in_array($this->environment['environment'], ['development', 'test', 'production'])) {
            return true;
        }

        return false;
    }
} 