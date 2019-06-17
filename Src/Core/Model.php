<?php

namespace Previateri\Bolton\Core;

abstract class Model
{
    private $db;
    private $query;
    private $result;
    protected $table;

    protected function __construct($connection, string $table)
    {
        $this->db = $connection;
        $this->table = $table;
    }

    protected function getAll()
    {
        $query = $this->setQuery();
        $this->setParams($query);
        $this->executeQuery();

        return $this->getResult();
    }

    protected function getOne($params)
    {
        $query = $this->setQuery($params);
        $this->setParams($query, $params);
        $this->executeQuery();

        return $this->getResult();
    }

    private function setQuery(Array $params = null)
    {
        if (is_null($params)) {
            return "SELECT * FROM {$this->table}";
        }

        $query = "SELECT * FROM {$this->table} WHERE ";

        $qtdParams = count($params);
        $counter = 0;
        
        foreach ($params as $key => $value) {
            $counter++;
            $query .= "{$key} = :{$key}";
            $query .= ($counter < $qtdParams ? " AND " : "");
        }

        return $query;
    }

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

    private function executeQuery()
    {
        $this->query->execute();
        $this->setResult();
    }

    private function setResult()
    {
        if ($this->query->rowCount() > 0) {
            $this->result = $this->query->fetchAll();
        } else {
            $this->result = ['results' => 0];
        }
    }

    public function getResult()
    {
        return $this->result;
    }
}