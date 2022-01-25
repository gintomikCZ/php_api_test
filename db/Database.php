<?php

Class Database {
  private static $instance = null;
  private $pdo = null;

  private function __construct() {
    try {
      $conData = parse_ini_file(__DIR__.'/db.ini');
      $conString = sprintf(
        "mysql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
        $conData['host'],
        $conData['port'],
        $conData['database'],
        $conData['user'],
        $conData['password']
      );
      $this->pdo = new PDO($conString);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public static function getInstance(){
    if(!isset(self::$instance)) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  public function fetchAll($query, $params = array(), $object = false, $class = null) {
    try {
      $statement = $this->pdo->prepare($query);
      $statement->execute($params);
      return $object
        ? $statement->fetchAll(PDO::FETCH_CLASS, $class)
        : $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function fetchOne($query, $params = array(), $object = false, $class = null){
    try {
      $statement = $this->pdo->prepare($query);
      if($object) {
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
      } else {
        $statement->setFetchMode(PDO::FETCH_ASSOC);
      }
      foreach($params as $key => $value) {
          $statement->bindValue(':'.$key, $value);
      }
      $statement->execute();
      return $statement->fetch();
    }
    catch(Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function addRecord($table, $data) {
    try {
      $query = 'INSERT INTO ' . $table.' (';
      $columns = array_keys($data);
      $query .= implode(',', $columns);
      $query .= ') VALUES (:';
      $query .= implode(', :', $columns);
      $query .= ')';
      $statement = $this->pdo->prepare($query);
      foreach($data as $key => $value) {
        $statement->bindValue(':'.$key, $value);
      }
      $statement->execute();
      return $this->pdo->lastInsertId();
    }
    catch(Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function deleteRecord($table, $id) {
    try {
      $query = "DELETE FROM ".$table." WHERE id =:id";
      $statement = $this->pdo->prepare($query);
      $statement->bindValue(':id', $id);
      $statement->execute();
      return $statement->rowCount();
    }
    catch(Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function editRecord($table, $data, $id = null) {
    try {
      if(!isset($data['id'])) {
        if (!$id) throw new Exception('The id is missing.');
        $data['id'] = $id;
      }
      $columns = array_keys($data);
      $query = 'UPDATE ' . $table . ' SET ';
      foreach ($columns as $column) {
        $query .= $column.' = :'.$column . ', ';
      }
      $query = trim($query);
      $query = substr($query, 0, strlen($query) -1);
      $query .= ' WHERE id = :id';
      $statement = $this->pdo->prepare($query);
      foreach($data as $key => $value) {
        $statement->bindValue(':'.$key, $value);
      }
      $statement->execute();
      return $id;
    }
    catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}
