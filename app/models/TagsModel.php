<?php

class UserSessionsModel extends Model {

  public function __construct() {
    $table = TAGS_TABLE;
    parent::__construct($table);
  }

  public function searchTags($keyword, $orderBy = 'name', $order, $limit, $offset) {
    if ($keyword == '') {
        return $this->findAll([
            'order' => $orderBy.' '.$order,
            'limit' => $limit,
            'offset' => $offset
        ]);
    } else {
        if(is_numeric($keyword)) {
            return  $this->findAll([
                'conditions' => "`id` = ?",
                'bind' => [$keyword],
                'order' => $orderBy.' '.$order,
                'limit' => $limit,
                'offset' => $offset
            ]);
        } else {
            return  $this->findAll([
                'conditions' => "(`alias` LIKE ? OR `name` LIKE ?)",
                'bind' => [self::wildcardLike($keyword),self::wildcardLike($keyword)],
                'order' => $orderBy.' '.$order,
                'limit' => $limit,
                'offset' => $offset
            ]);
        }
    }
  }


  public function saveTag($tag){
    

  }
}
