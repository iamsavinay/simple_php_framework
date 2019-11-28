<?php

class Model {
  protected $_db, $_table, $_softDelete = false, $_columnNames = [];
  public $id;

  public function __construct($table) {
    $this->_db = DB::getInstance();
    $this->_table = $table;
    $this->_setTableColumns();
    $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))).'Model';
  }

  protected function _setTableColumns() {
    $columns = $this->getColumns();
    foreach($columns as $column) {
      $columnName = $column->Field;
      $this->_columnNames[] = $column->Field;
      $this->{$columnName} = null;
    }
  }

  public function countMatched($params) {
    return $this->_db->countMatched($this->_table, $params);
  }

  public function countRows() {
    return $this->_db->countRows($this->_table);
  }

  public function getColumns() {
    return $this->_db->getColumns($this->_table);
  }

  public function findAll($params = []) {
    $results = [];
    $resultQuery = $this->_db->findAll($this->_table, $params);
    if($resultQuery) {
      foreach($resultQuery as $result){
        $obj = new $this->_modelName();
        $obj->populateObjData($result);
        $results[] = $obj;
      }
      return $results;
    }
    return false;
  }

  public function findFirst($params = []) {
    $resultQuery = $this->_db->findFirst($this->_table, $params);
    if($resultQuery) {
      $obj = new $this->_modelName();
      $obj->populateObjData($resultQuery);
      return $obj;
    }
    return false;
  }

  public function findByID($id) {
    return $this->findFirst([
      "conditions" => "id = ?",
      "bind" => [$id]
    ]);
  }

  public function save() {
    $fields = [];
    foreach($this->_columnNames as $column) {
      $fields[$column] = $this->$column;
    }
    
    if(property_exists($this, 'id') && $this->id != '') {
      return $this->update($this->id, $fields);
    } else {
      return $this->insert($fields);
    }
  }

  public function insert($fields) {
    if(!empty($fields)) return $this->_db->insert($this->_table, $fields);
    return false;
  }

  public function update($id, $fields) {
    if(!empty($fields) || $id != '') return $this->_db->update($this->_table, $id, $fields);
    return false;
  }

  public function enablePermDelete() {
    $this->_softDelete = false;
  }

  public function delete($id = '') {
    if($id == '' && $this->id == '') return false;
    $id = ($id == '') ? $this->id : $id;
    if($this->_softDelete) {
      $this->update($id, ['disable' => 1]);
    }
    return $this->_db->delete($this->_table, $id);
  }

  public function query($sql, $bind = []) {
    return $this->_db->query($sql, $bind);
  }

  public function lastID() {
    return $this->_db->lastID();
  }

  public function results() {
    return $this->_db->results();
  }

  public function count() {
    return $this->_db->count();
  }

  public function assign($params, $filter = false) {
    if(!empty($params)) {
      if($filter) {
        foreach($params as $key => $value) {
          if (in_array($key, $this->_columnNames)) {
            $this->$key = Input::sanitize($value);
          }
        }
      } else {
        foreach($params as $key => $value) {
          if (in_array($key, $this->_columnNames)) {
            $this->$key = $value;
          }
        }
      }
    }
  }

  public function populateObjData($result) {
    foreach($result as $key => $value) {
      $this->$key = $value;
    }
  }
}
