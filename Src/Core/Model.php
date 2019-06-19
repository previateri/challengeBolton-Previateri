<?php

namespace Previateri\Bolton\Core;

/**
 * Abstract Class Model
 * A classe abstrata model define métodos que poderão ser implementados pelas classes filhas do tipo Model.
 * Esses métodos possibilitam a manipulação de dados no banco de maneira uniforme. 
 */
abstract class Model
{
    private $db;
    private $query;
    private $result;
    protected $table;

    /**
     * Method __construct($connection, $table)
     * Ao ser instanciado um novo objeto da classe Model, o constutor exige que dois parâmetros
     * sejam informados. Esses parâmetros são armazenados nos respectivos atributos e são utilizados
     * em todo ciclo de vida da classe.
     * @param Object $connection A instância da conexão dos sistema com o banco de dados
     * @param String $table A tabela padrão que será manipulada pelo model
     */
    protected function __construct($connection, string $table)
    {
        $this->db = $connection;
        $this->table = $table;
    }

    /**
     * Method getAll()
     * O método é responsável por montar a query que irá buscar todos os dados da tabela
     * padrão informada no construtor da classe. O método utiliza o setQuery(), o setParams(), o executeQuery() e o getResult()
     * mara montar, excecutar e rotornar os resultados da query.
     */
    protected function getAll()
    {
        $query  = "SELECT * FROM {$this->table}";
        $query .= $this->setQuery();
        $this->setParams($query);
        $this->executeQuery();

        return $this->getResult();
    }

    /**
     * Method getOne($params)
     * O método é responsável por montar e executar a query que irá buscar um único registro
     * na tabela padrão informada no construtor da clase. O método utiliza o setQuery(), o setParams(), o executeQuery() e
     * o getResult() para montar, executar e retornar os resultados da query.
     */
    protected function getOne($params)
    {
        $query  = "SELECT * FROM {$this->table} WHERE ";
        $query .= $this->setQuery($params);
        $query .= " LIMIT 1";
        $this->setParams($query, $params);
        $this->executeQuery();

        return $this->getResult();
    }

    /**
     * Method insert(Array $params)
     * O método é responsável por monstar e executar a query que irá inserir um novo registro na
     * tabela padrão informada no construtor da classe. O método utiliza o setQuery(), o setparams(), p
     * executeQuery() para montar, executar e retornar os resultados da query.
     */
    protected function insert(Array $params)
    {
        $query  = "INSERT INTO {$this->table} SET ";
        $query .= $this->setQuery($params, true);
        $this->setParams($query, $params);
        $this->executeQuery();
    }

    /**
     * Method setQuery(Array $params, Bollean $insert)
     * Método responsável por montar a estrutura da query que será executada 
     * os parâmetros necessários são:
     * @param Array $param Os parâmetros que serão utilizados na montadem da
     * query que posteriormente será preparada pelo PDO Ex: nome = :nome
     * @param Bollean $insert identifica se a query será um Select ou um Insert (insert ou update)
     * para setar corretamente o valor da variávelc concat
     * @return String
     */
    private function setQuery(Array $params = null, $insert = false)
    {
        if (is_null($params)) {
            return false;
        }

        $qtdParams = count($params);
        $counter = 0;
        
        $query  = '';
        $concat =  ($insert ? ', ' : ' AND ');

        foreach ($params as $key => $value) {
            $counter++;
            $query .= "{$key} = :{$key}";
            $query .= ($counter < $qtdParams ? $concat : "");
        }

        return $query;
    }

    /**
     * Method setParams(String $query, Array $params)
     * O método é responsável por realizar o Prepare Statement do PDO
     * os parâmetros necessários são:
     * @param String $query A query já montada anteriormente
     * @param Array $params O array com os índices e valores respectivos que passarão
     * pelo método bindValue() do PDO.
     */
    private function setParams(String $query, Array $params = null)
    {
        $this->query = $this->db->prepare($query);

        if (is_null($params)) {    
            return;
        }
       
        foreach ($params as $key => $value) {
            $this->query->bindValue(":{$key}", $value);
        }

    }

    /**
     * Method executeQuery()
     * Método responsável pela execução da query no banco de dados através do método execute() do PDO
     * após a execução o método ainda seta o resultado através do método setResult()
     */
    private function executeQuery()
    {
        $this->query->execute();
        $this->setResult();
    }

    /**
     * Method setResult()
     * Responsável por verificar se a execução da query trouxe resultados e armazenar no 
     * atributo $result as linhas resultantes ou o valor 0 caso não haja resultados.
     */
    private function setResult()
    {
        if ($this->query->rowCount() > 0) {
            $this->result = $this->query->fetchAll();
        } else {
            $this->result = ['results' => 0];
        }
    }

    /**
     * Mehtod getResult()
     * Responsável por fornecer o valor armazenado no atributo $result que contém o
     * resultado da execução das querys.
     */
    public function getResult()
    {
        return $this->result;
    }
}