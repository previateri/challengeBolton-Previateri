<?php

namespace App\Controllers;

use Previateri\Bolton\Core\Requests;

/**
 *  Class RequestController
 *  A classe é responsável por fornecer uma interface de fácil utilização a funcionanilidade
 *  de requests utilizando Curl. Construida utilizando o Padrão Builder a classe garante que
 *  seja possível criar diferentes tipos de requests.
 *  Alguns atributos são pré-definidos para garantir que a request funcione mesmo utilizando
 *  o mínimo possível de configurações.
 */
class RequestController
{

    private $containerSaveResults;
    private $containerSaveRequests;
    private $request        = null;
    private $baseUrl        = null;
    private $protocol       = 'http';
    private $header         = array();
    private $requestMethod  = 'GET';
    private $requestString  = '';
    private $params         = null;
    private $response;


    /**
     * Method setContainnersModel($containerSaveResults, $containerSaveRequests)
     * Esse método seta as dependências necessárias para as ações de salvar os
     * resultados da request e salvar informações da request disparada. Ambos
     * são Models que possuem os métodos necessários para as ações.
     * @param Object $containerSaveRequests Model que será responsável por salvar
     * os resultados da resultados da request.
     * @param Object $containerSaveRequests Model que será responsável por salvar
     * as informações da execução da request.
     */
    public function setContainnersModel($containerSaveResults, $containerSaveRequests)
    {
        $this->containerSaveResults     = $containerSaveResults;
        $this->containerSaveRequests    = $containerSaveRequests;
    }

    public function baseUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function protocol(string $protocol)
    {
        $this->protocol = $protocol;
        return $this;
    }

    public function setHeader(Array $header)
    {
        $this->header = $header;
        return $this;
    }
    
    public function requestMethod(String $method)
    {
        $this->requestMethod = $method;
        return $this;
    }

    public function requestString(String $requestString)
    {
        $this->requestString .= $requestString;
        return $this;
    }

    /**
     * Method setParams($params)
     * Método responsável por setar parâmetros específicos para a request
     * caso seja requisitado.
     * O método recebe um array de parâmetros e o itera gerando uma string
     * que é armazenada no atributo $param.
     * @param Array $params Array com os parâmetros específicos a serem injetados na request.
     */
    public function setParams(Array $params)
    {
        $param = '?';
        foreach ($params as $key => $value){
            $param .= "{$key}=$value&";
        }
        $param = rtrim($param, '&');

        $this->params = $param;

        return $this;
    }

    /**
     * Method executeRequest()
     * O método é responsável por preparar e executar a request, armazenando o resultado.
     * Primeiro o método seta o parâmetro $baseUri e em seguida instancia um novo objeto da
     * classe Requests passando no seu construtor os parâmetros necessários. Essa ação garante
     * que a request seja imutável até o fim do seu uso.
     * Ao executar a request através do método executeRequest() da classe Requests, armazena o 
     * resultado na propriedade response.
     */
    public function executeRequest()
    {
        $this->baseUri = "{$this->protocol}://{$this->url}";
        
        if (is_null($this->request)) {
            $this->request = new Requests($this->baseUri, $this->header);
        }
        
        $this->response = $this->request->executeRequest($this->requestMethod, $this->requestString, $this->params);

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Method getStatus()
     * Utiliza o método getStatus() da classe Requests para retornar o status da requisição
     * que foi realizada.
     */
    public function getStatus()
    {
        return $this->request->getStatus();
    }

    /**
     * Method getContent()
     * Utiliza o método getBody() da classe Requests para retornar o conteúdo do "corpo"
     * da resposta da request.
     */
    public function getContent()
    {
        return $this->request->getBody();
    }

    /**
     * Method saveResult(Array $dataResult)
     * Utiliza o model responsável para chamar o método insert() que armazenará no banco
     * de dados o conteúdo enviado pelo parâmetro $dataResult.
     */
    public function saveResult(Array $dataResult)
    {
        $this->containerSaveResults->insert($dataResult);
    }

    /**
     * Method saveRequest(Array $dataRequesst)
     * Utiliza o model responsável para chamar o método insert() que armazenará no banco
     * de dados as informações da request armazenado pelo parâmetro $dataRequest.
     */
    public function saveRequest(Array $dataRequest)
    {
        $this->containerSaveRequests->insert($dataRequest);
    }

    /**
     * Method saveRequestOnPath($configPath, $fileContent)
     * Método responsável por armazenar no servidor o conteúdo da request,
     * os parâmetros $configPath e $fileContent definem o caminho da pasta onde
     * será armazenado e o seu conteúdo respectivamente.
     */
    public function saveRequestOnPath($configPath, $fileContent)
    {
        $uniqueFile = sha1(time() . rand(0,999));
        $configPath = dirname(dirname(__DIR__)) . '/' . $configPath;

        file_put_contents("{$configPath}/request_response_{$uniqueFile}.json", $fileContent);
    }
}