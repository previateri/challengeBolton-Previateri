<?php
/**
 * RequestConfig.php
 * O arquivo é utilizado para setar as configurações que serão utilizados no objeto request
 * da classe RequestController. As informações são armazenadas no array $requestConfig através
 * da função initializeConfigRequest().
 */



/**
 * Function initializeConfigRequest()
 * Quando invocada a função seta os valores informados na array $requestConfig e
 * em seguida retorna a array para ser utilizada.
 *  
 * @param Object $instanceDB Instância da classe BdConnection
 * @return Array $requestConfig
 */
function initalizeConfigRequest(Object $instanceDB){
    $requestConfig = [
        'protocol'       => 'http',
        'baseUri'        => 'apiuat.arquivei.com.br' ,
        'header'         => [
                            'Content-Type' => 'application/json',
                            'x-api-id'     => 'e021f345e68de190b17becb313e81f7874479bcb',
                            'x-api-key'    => 'c0d24ab7b6a1732189cabf4d7d4896031c8a25dc'
        ],
        'requestString'  => '/v1/nfe/received',
        'params'         => [
                            'limit'  => 50,
                            'cursor' => 1,
        ],
        'method'         => 'GET',
        'containerModel' => new \App\Models\NfsModel($instanceDB),
        'requestModel'   => new \App\Models\RequestsModel($instanceDB),
        'requests-path'  => "request-responses",
    ];

    return $requestConfig;
}