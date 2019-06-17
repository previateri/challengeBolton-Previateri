<?php

//Registramos o endpoit responsável por fornecer o acesso as notas fiscais armazenadas no BD
$router->add('GET', '/v0/nfs/minhasnotasficais/(\d+)', "\App\Controllers\NfsController::getOne");