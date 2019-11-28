<?php

class CitiesModel extends Model {

  public function __construct() {
    $table = CITIES_TABLE;
    parent::__construct($table);
  }

  public static function searchCities($orderBy = 'name', $order, $limit = 20, $offset) {
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
}
