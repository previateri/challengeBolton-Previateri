<?php
/** Carrega o autload do composer. */
require __DIR__ . '/vendor/autoload.php';

use Previateri\Bolton\Config\BdConnection as bdInstance;
use Previateri\Bolton\Core\Router;
use Previateri\Bolton\Core\Response;

/** Obtém a instância do banco de dados a ser utilizada e armazena na variável $db. */
try {
    $db = bdInstance::getInstance()->getDb();
} catch (\Previateri\Bolton\Exceptions\DatabaseExceptions $e) {
    echo json_encode(['error' => $e->getMessage()]);
    die;
}

/** Instancia um novo objeto da classe Router. */
$router = new Router;

/** Carrega o arquivo que contém os registros das rotas configuradas. */
require __DIR__ . '/Src/Config/Routes.php';

try {
    /** Executa o método run() da classe Router armazenando o resultado na variável result. */
    $result =  $router->run();
    
    /** Instancia um novo objet da classe Response. */
    $response = new Response;
    
    /** Prepara os valores que serão injetados na instância da classe Response. */
    $params = [
        "dbConnection"  => $db,
        "params"        => $result['params'],
    ];

    /** Invoca a execução do Response. */
    $response($result['action'], $params);

} catch (\Previateri\Bolton\Exceptions\HttpExceptions $e) {
    /**Caso seja utilizado uma rota não registrada retorna o erro correspondente. */
    echo json_encode(['error' => $e->getMessage()]);
}