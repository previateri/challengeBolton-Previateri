<?php
/** Carrega o autoload do composer. */
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\RequestController;
use Previateri\Bolton\Config\BdConnection as bdInstance;

/** Obtém a instância do banco de dados a ser utilizada e armazena na variável $db. */
try {
    $db = bdInstance::getInstance()->getDb();
} catch (\Previateri\Bolton\Exceptions\DatabaseExceptions $e) {
    echo json_encode(['error' => $e->getMessage()]);
    die;
}


/** Carrega o arquivo que contém as configurações que serão utilizadas na request. */
require __DIR__ . '/App/Config/RequestsConfig.php';

/** 
 * Carrega as comfigurações para a variável $requestConfig através da função
 * initializeConfigRequest() passando como parâmetro a instância do banco carregada.
 * */
$requestConfig = initalizeConfigRequest($db);

/** Obtêm uma nova intância da classe RequestController*/
$request = new RequestController;

/** Realiza o set de dois parâmetros através do método setContainersModel(). */
$request->setContainnersModel($requestConfig['containerModel'], $requestConfig['requestModel']);

/** Realiza o builder da requisição utilizando as configurações carregadas na variável $requestConfig. */
$requestResult = $request->protocol($requestConfig['protocol'])
                        ->baseUrl($requestConfig['baseUri'])
                        ->setHeader($requestConfig['header'])
                        ->requestString($requestConfig['requestString'])
                        ->setParams($requestConfig['params'])
                        ->requestMethod($requestConfig['method'])
                        ->executeRequest();

                        
/** Uitliza o método getStatus() da classe RequestController para verificar se a requisição retornou um código 200. */                        
if ($requestResult->getStatus() == 200) {

    /** Carrega através da função json_decode() o retorno da chamada do método getContent() da classe RequestController. */
    $jsonResult = json_decode($requestResult->getContent());
    
    /** Itera entre todos os resultados armazenados na variável $jsonResult armazenando os desejados no array $dataNF. */
    foreach ($jsonResult->data as $result) {
        $dataNF['access_key']   = $result->access_key;
        $dataNF['xml_value']    = $result->xml;
        $dataNF['created']      = date('Y-m-d H:i:s');
        /** Para cada resultado recuperado envia através do method saveResult() da classe RequestController. */
        $request->saveResult($dataNF);
    }

}

/** 
 * Armazena informações genéricas do resultado da request
 *  no array $dataRequest para enviar o histórico da
 *  request ao banco de dados.
 */
$dataRequest['status_code']     = $requestResult->getStatus();
$dataRequest['status_message']  = $jsonResult->status->message;
$dataRequest['count']           = $jsonResult->count;
$dataRequest['page_next']       = $jsonResult->page->next;
$dataRequest['page_previous']   = $jsonResult->page->previous;
$dataRequest['signature']       = $jsonResult->signature;
$dataRequest['request_date']    = date('Y-m-d H:i:s');

/** Envia o array $dataRequest com as informações através do método saveRequest() da classe RequestContrller. */
$request->saveRequest($dataRequest);

/** 
 * Envia o conteúdo do "body" da request através do método saveRequestOnPath()
 * da classe RequestController para ser armazenado em uma pasta no servidor.
 * */
$request->saveRequestOnPath($requestConfig['requests-path'], $requestResult->getContent());