<?php

/** Registro da rota do endpoint que será responsável por fornecer ao acesso 
 *  as notas fiscais armazenadas no Banco de Dadps 
 */
$router->add('GET', '/v0/nfs/minhasnotasficais/(\d+)', "\App\Controllers\NfsController::getOne");