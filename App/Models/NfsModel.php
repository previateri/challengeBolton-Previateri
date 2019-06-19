<?php

namespace App\Models;

use Previateri\Bolton\Core\Model;

/**
 * Class NfsModel
 * A classe define os métodos responsáveis pela manipulação de dados (recuperação e inserção)
 * no banco de dados. 
 * Em sua maioria, os métodos são apenas assinaturas de métodos da classe pai Model.
 */
class NfsModel extends Model
{
    /**
     * Method __construct($dbInstance)
     * Recebe como parãmetro o valor $dbInstance que é uma instância ativa da conexão
     * com o banco de dados e utiliza o construtor da classe pai Model para iniciar a conexão
     * e setar a tabela padrão que será utilizada
     */
    public function __construct($dbInstance)
    {
        parent::__construct($dbInstance, 'nfe_arquivei');
    }

    /**
     * Method getAll()
     * Utiliza o método getAll() para buscar todas as informações da tabela padrão declarada
     * no construtor. O método repassa o retono da classe pai Model.
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * Method getOne()
     * Utiliza o método getOne() para buscar uma única informação na tabela padrão declarada
     * no construtor. O método repassa o retorno da classe pai Model.
     */
    public function getOne($params)
    {
        return parent::getOne($params);
    }

    /**
     * Method insert()
     * Utiliza o método insert() da classe pai Model para inserir um novo valor na tabela
     * padrão declarada no constutor. O método repassa o retorno da classe pai Model ao final da inserção.
     */
    public function insert($params)
    {
        return parent::insert($params);
    }
}