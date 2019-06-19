<?php

namespace App\Models;

use Previateri\Bolton\Core\Model;

/**
 * Class RequestsModel
 * A classe define os métodos responsáveis pela manipulação de dados (recuperação e inserção)
 * no banco de dados referente as informações das execuções das requests. 
 * Em sua maioria, os métodos são apenas assinaturas de métodos da classe pai Model.
 */
class RequestsModel extends Model
{
    public function __construct($dbInstance)
    {
        parent::__construct($dbInstance, 'requests_history');
    }

    public function getAll()
    {
        return parent::getAll();
    }

    public function getOne($params)
    {
        return parent::getOne($params);
    }

    public function insert($params)
    {
        return parent::insert($params);
    }
}