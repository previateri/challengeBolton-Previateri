<?php

namespace App\Controllers;

/**
 * Class NfsController
 * Controller responsável pela manipulação das Notas Fiscais, os métodos são
 * que retornam informações devem passar as mesmas no formato de array('chave' => valor).
 *
*/
class NfsController
{
    /**
     * Method getOne($dbConnection, $params)
     * O método utiliza o model NfsModel para retornar um registro específico de acordo
     * com o parâmetro informado.
     * @param Object $dbConnection Instância da conexão com o banco de dados
     * @param Array $params Parâmetros que podem ser utilizados pelo método
     * @return Array
     */
    public function getOne($dbConnection, $params)
    {
        $db = $dbConnection;
        $nfsModel = new \App\Models\NfsModel($db);

        $response = $nfsModel->getOne(['access_key' => $params[1]]);
        //$response = $nfsModel->getAll();

        return $response;
    }
}