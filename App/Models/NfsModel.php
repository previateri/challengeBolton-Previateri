<?php

namespace App\Models;

use Previateri\Bolton\Core\Model;

class NfsModel extends Model
{
    public function __construct($dbInstance)
    {
        parent::__construct($dbInstance, 'mynfs');
    }

    public function getAll()
    {
        return parent::getAll();
    }

    public function getOne($params)
    {
        return parent::getOne($params);
    }
}