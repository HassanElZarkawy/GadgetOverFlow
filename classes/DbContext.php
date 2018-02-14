<?php

class DbContext{
    private static $_instance = null;
    public $_pdo,
    $_query,
    $_error = false,
    $_results,
    $_count = 0,
    $_last_id = 0;
    private $errorMessage;
    
    private function __construct($database)
    {
         $this->_pdo = new PDO("mysql:host=localhost;dbname=$database;charset=UTF8", 'USERNAME', '######');
    }
    
    public static function getInstance($database = 'gadgetoverflow')
    {
        if(!isset(self::$_instance)){
            self::$_instance = new DbContext($database);
        }
        return self::$_instance;
    }

    public static function connect($database) {
        return  new DbContext($database);
    }
    
    public function query($sql, $params = array())
    {
        $this->_error = FALSE;
        //$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        if($this->_query = $this->_pdo->prepare($sql)){
            $x = 1;
            if(count($params)){
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                $this->_last_id = $this->_pdo->lastInsertId();
            } else {
                $this->_error = TRUE;
                $this->errorMessage = $this->_query->errorInfo();
            }
        }
        return $this;
    }
    
    public function insert($table, $fields = array())
    {
        if(count($fields)){
            $keys = array_keys($fields);
            $values = '';
            $x = 1;
            
            foreach($fields as $field){
                $values .= $this->_pdo->quote($field);
                //$values .= '?';
                if ($x < count($fields)){
                    $values .= ', ';
                }
                $x++;
            }
            
            $sql = "INSERT INTO $table (". implode(', ', $keys) .") VALUES ({$values})";
            //echo $sql;
            //die();
            if (!$this->query($sql)->error()){
                return true;
            }
        }
        return false;
    }
    
    public function update($table, $searchColumn, $searchValue, $fields)
    {
        $set = '';
        $x = 1;
        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ", ";
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE {$searchColumn} = {$searchValue}";
        if (!$this->query($sql, $fields)->error()){
            return true;
        }
        return false;
    }

    public function action($action, $table, $where)
    {
        if(count($where) === 3){
            
            $column = $where[0];
            $operator = $where[1];
            $value = $where[2];
            
            $sql = "$action FROM $table WHERE $column $operator ?";
            if(!$this->query($sql, array($value))->error()){
                return $this;
            }
        }
        return FALSE;
    }
    
    public function get($table, $where = array())
    {
        return $this->action("SELECT *", $table, $where);
    }
    
    public function delete($table, $where = array())
    {
        return $this->action("DELETE ", $table, $where);
    }
    
    public function results()
    {
        return $this->_results;
    }
    
    public function first()
    {
        return $this->results()[0];
    }
    
    public function error()
    {
        return $this->_error;
    }
    
    public function count()
    {
        return $this->_count;
    }

    public function lastId() 
    {
        return $this->query('SELECT LAST_INSERT_ID()')->first();
    }

    public function errorInfo() {
        return $this->errorMessage;
    }
}