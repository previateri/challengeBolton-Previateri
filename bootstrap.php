<?php

require __DIR__ . '/vendor/autoload.php';

use Previateri\Bolton\Config\BdConnection as bdInstance;
use Previateri\Bolton\Core\Router;

try {
    $db = bdInstance::getInstance()->getDb();
} catch (\Previateri\Bolton\Exceptions\DatabaseExceptions $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$router = new Router;

//Arquivo de registros das rotas
require __DIR__ . '/Src/Config/Routes.php';

try {
    echo $router->run();
} catch (\Previateri\Bolton\Exceptions\HttpExceptions $e) {
    echo json_encode(['error' => $e->getMessage()]);
}