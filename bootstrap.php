<?php

require __DIR__ . '/vendor/autoload.php';

use Previateri\Bolton\Config\BdConnection as bdInstance;
use Previateri\Bolton\Core\Router;
use Previateri\Bolton\Core\Response;

try {
    $db = bdInstance::getInstance()->getDb();
} catch (\Previateri\Bolton\Exceptions\DatabaseExceptions $e) {
    echo json_encode(['error' => $e->getMessage()]);
    die;
  }

$router = new Router;

//Arquivo de registros das rotas
require __DIR__ . '/Src/Config/Routes.php';

try {
    $result =  $router->run();
    $response = new Response;
    
    $params = [
        "dbConnection"  => $db,
        "params"        => $result['params'],
    ];

    $response($result['action'], $params);

} catch (\Previateri\Bolton\Exceptions\HttpExceptions $e) {
    echo json_encode(['error' => $e->getMessage()]);
}