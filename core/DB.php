<?php

class DB {
  private static $_instance = null;
  private $_pdo, $_qeury, $_error = false, $_result, $_count = 0, $_lastInsertID = null;

  public function __construct() {
    try {
      $this->_pdo = new PDO(DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
      $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch(PDOException $e) {
      die($e->getMessage());
    }
  }

  public static function getInstance() {
    if(isset(self::$_instance) && self::$_instance != null) {
      return self::$_instance;
    } else {
      return self::$_instance = new DB;
    }
  }

  public function query($sql, $params = []) {
    $this->_error = false;
    if ($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;
      if(count($params)) {
        foreach ($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }
    }
    if($this->_query->execute()) {
      $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
      $this->_count = $this->_query->rowCount();
      $this->_lastInsertID = $this->_pdo->lastInsertID();
    } else {
      $this->_error = true;
    }
    return $this;
  }

  protected function _read($table, $params) {

    $conditionString = '';
    $bind = [];
    $order = '';
    $limit = '';
    $offset = '';

    // conditions
    if(isset($params['conditions'])) {
      if(is_array($params['conditions'])) {
        foreach($params['conditions'] as $condition) {
          $conditionString .= ' '.$condition.' AND';
        }
        $conditionString = trim($conditionString);
        $conditionString = rtrim($conditionString, 'AND');
      } else {
        $conditionString = $params['conditions'];
      }
      if($conditionString != '') {
        $conditionString = ' WHERE '.$conditionString;
      }
    }

    // bind
    if (array_key_exists('bind', $params)) {
      $bind = $params['bind'];
    }

    // order
    if(array_key_exists('order', $params)) {
      $order  = ' ORDER BY '.$params['order'];
    }

    // limit
    if(array_key_exists('limit', $params)) {
      $limit = ' LIMIT '.$params['limit'];
    }

    // offset
    if(array_key_exists('offset', $params)) {
      $offset = ' OFFSET '.$params['offset'];
    }


  $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}{$offset}";

    if(!$this->query($sql, $bind)->error()) {
      if(!count($this->_result)) return false;
      return true;
    }
    return false;
  }

  protected function _count($table, $params) {

    $conditionString = '';
    $bind = [];

    // conditions
    if(isset($params['conditions'])) {
      if(is_array($params['conditions'])) {
        foreach($params['conditions'] as $condition) {
          $conditionString .= ' '.$condition.' AND';
        }
        $conditionString = trim($conditionString);
        $conditionString = rtrim($conditionString, 'AND');
      } else {
        $conditionString = $params['conditions'];
      }
      if($conditionString != '') {
        $conditionString = ' WHERE '.$conditionString;
      }
    }

    // bind
    if (array_key_exists('bind', $params)) {
      $bind = $params['bind'];
    }


    $sql = "SELECT count(1) FROM `{$table}`{$conditionString}";
    if(!$this->query($sql, $bind)->error()) {
      if(count($this->_result)) {
        return true;
      }
    }
    return false;
  }

  public function insert($table, $fields = []) {
    $fieldString = '';
    $valueString = '';
    $values = [];

    foreach ($fields as $field => $value) {
      $fieldString .= '`' . $field . '`,';
      $valueString .=  '?,';
      $values[] = $value;
    }
    $fieldString = rtrim($fieldString, ',');
    $valueString = rtrim($valueString, ',');

    $sql = "INSERT INTO `{$table}` ({$fieldString}) VALUES ({$valueString})";

    if(!$this->query($sql, $values)->error()) {
      return true;
    }
    return false;
  }

  public function update($table, $id, $fields = []) {
    $fieldString = '';
    $values = [];
    // Helper::dump($fields);
    
    foreach ($fields as $field => $value) {
      if(!empty($value)) {
        $fieldString .= ' `'.$field. '` = ?,';
        // $fields[] = $field;
        $values[] = $value;
      }
      // echo ('Field: '.$field.'<br />');
      // echo ('Value: '.$value.'<br />');
      //debug changes
    }
    $fieldString = trim($fieldString);
    $fieldString = rtrim($fieldString, ',');
    $sql = "UPDATE `{$table}` SET {$fieldString} WHERE `id` = {$id}";
    // Helper::dump(($fieldString));
    // Helper::dump(($values));
    // Helper::dnd($sql);
    if(!$this->query($sql, $values)->error()) {
      return true;
    }
    return false;
  }

  public function delete($table, $id) {
    $sql = "DELETE FROM `{$table}` WHERE `id` = {$id}";
    if(!$this->query($sql)->error()) {
      return true;
    }
    return false;
  }

  public function findAll($table, $params = []) {
    // if ($params == []) return false;
    if($this->_read($table, $params)) {
      return $this->results();
    }
    return false;
  }

  public function findFirst($table, $params = []) {
    // if ($params == []) return false;
    if($this->_read($table, $params)) {
      return $this->first();
    }
  }

  public function countMatched($table, $params) {
    if($this->_count($table, $params)) {
      $c = 'count(1)';
      return $this->_result[0]->$c;
    }
  }

  public function countRows($table){
    $this->query("SELECT count(1) FROM `{$table}`");
    $c = 'count(1)';
    return $this->_result[0]->$c;
  }

  public function results() {
    return $this->_result;
  }

  public function first() {
    return (!empty($this->_result)) ? $this->_result[0] : false;
  }

  public function count() {
    return $this->_count;
  }

  public function lastID() {
    return $this->_lastInsertID;
  }

  public function getColumns($table) {
    return $this->query("SHOW COLUMNS FROM `{$table}`")->results();
  }

  public function error() {
    return $this->_error;
  }
}
