<?php

//Registramos o endpoit responsável por fornecer o acesso as notas fiscais armazenadas no BD
$router->add('GET', '/v0/nfs/minhasnotasficais/(\d+)', function ($params) use ($db) {
    return 'estamos listando projeto de id: ' . $params[1];
});
