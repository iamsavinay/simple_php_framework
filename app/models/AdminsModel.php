<?php

class AdminsModel extends Model {

  public function __construct() {
    $table = USERS_TABLE;
    parent::__construct($table);
  }

  public function countUsers() {
    return $this->countRows();
  }

  public function searchUsers($keyword, $offset) {
    $result = $this->search(USERS_TABLE, $keyword, 'DESC', $offset);
    return $result;
  }

  // public function countRows($table) {
  //   $this->query("SELECT count(1) FROM ".$table);
  //   $result = $this->results();
  //   if(!empty($result)) {
  //       $count = 'count(1)';
  //       return $result[0]->$count;
  //   }
  //   return 0;
  // }

  public function search($table, $keyword, $order = '', $offset = 0, $limit = 20) {
    if($keyword != '') {
    $sql = "SELECT * FROM `{$table}` WHERE (`username` LIKE '%{$keyword}%' OR `fname` LIKE '%{$keyword}%' OR `lname` LIKE '%{$keyword}%' OR `email` LIKE '%{$keyword}%') ORDER BY `id` {$order} LIMIT {$limit} OFFSET {$offset}";
      //$this->query("SELECT * FROM ".$table." WHERE (`id` LIKE '{$keyword}' `username` LIKE '%{$keyword}%' OR `fname` LIKE '%{$keyword}%' OR `lname` LIKE '%{$keyword}%' OR `email` LIKE '%{$keyword}%') ORDER BY `id` {$order} LIMIT {$limit} OFFSET {$offset}");    
      $this->query($sql);
    } else {
      $this->query("SELECT * FROM ".$table." ORDER BY `id` {$order} LIMIT {$limit} OFFSET {$offset}");
    }

    $result = $this->results();
    if(!empty($result)) {
        return $result;
    }
    return false;
  }

  public function getUser($id) {
    return $this->findByID($id);
  }

  // public function updateData($table, $field, $id, $new_data) {
  //   $columns = $this->getColumnNames($table);
  //   if(in_array($field, $columns)) {
  //     $obj = new Model($table);
  //     $res = $obj->update($id, [
  //       $field => $new_data
  //     ]);
  //     dnd($res);
  //   }
  //   if (in_array($field, $columns)) {
      
  //     if ($res == true) return true;
  //   }
  //   return false;
  // }

  public function getTableColumns($table){
    $obj = new Model($table);
    return $obj->getColumns();
  }

  public function getColumnNames($table) {
    $obj = new Model($table);
    $columns = $obj->getColumns();
    $clm = [];
    if(count($columns) < 1) return false;
    foreach($columns as $column) {
      $columnName = $column->Field;
      $clm[] = $column->Field;
    }
    return $clm;
  }

}
