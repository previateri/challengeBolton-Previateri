<?php

namespace Previateri\Bolton\Core;

/**
 * Class Requests
 * A classe é responsável por interagir diretamente com o pacote
 * GuzzleHttp que realiza as requisições CURL. A classe provê métodos
 * que podem ser utilizaodos para realização ações no Guzzle.
 */
class Requests
{
    protected $client;
    protected $response;

    /**
     *  Method __construct(String $baseUri, Array $headers)
     * O método construtor garante que sempre que uma nova instância seja criada
     * essa armazene na propriedade $cliente uma instância única e imutável do
     * client onde irá executar as requests.
     * @param String $baseUri String base que contém a Uri de base para as requisições.
     * @param Array  $headers Array que contém as configurações a serem inseridas no client
     */
    public function __construct(String $baseUri, Array $headers)
    {
        $this->client = new \GuzzleHttp\Client([
                'base_uri'       => $baseUri,
                'headers'        => $headers,
            ]
        );
    }

    /**
     * Method executeRequest(String $method, String $stringRequest, $params)
     * Esse método executa a requisição através do método request() do Guzzle
     * Os parâmetros necesários são o método http da requisição, a url a ser requisitada
     * e caso necessário, os parâmetros adicionais para a url.
     * Ao executar o método armazena a resposta da request no parâmetro response.
     */
    public function executeRequest(String $method, String $stringRequest, $params = null)
    {
        $method = strtoupper($method);
        $params = ($params ? $params : '');
        $stringRequest = strtolower($stringRequest) . strtolower($params);

        try {
            $this->response = $this->client->request($method, $stringRequest);
        } catch (Exception $e) {
            $this->response = $e->getMessage();
        }

    }

    /**
     * Method getStatus()
     * Fornece o statusCode() que foi armazenado no parâmetro response
     * após a execução da request. O método utiliza o método getStatusCode() do Guzzle.
     */
    public function getStatus()
    {
        return $this->response->getStatusCode();
    }

    /**
     * Method getBody()
     * Fornece o "corpo" da resposta armazenado no parâmetro response
     * após a execução da request. O método utliza o método getBody() do Guzzle.
     */
    public function getBody()
    {
        return $this->response->getBody();
    }

}