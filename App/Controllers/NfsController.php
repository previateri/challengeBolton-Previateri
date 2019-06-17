<?php

namespace App\Controllers;

class NfsController
{
    public function getOne($dbConnection, $params)
    {
        $db = $dbConnection;
        $nfsModel = new \App\Models\NfsModel($db);

        $response = $nfsModel->getOne(['chave' => $params[1]]);
        //$response = $nfsModel->getAll();

        return $response;
    }
}