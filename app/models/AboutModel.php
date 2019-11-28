<?php

class AboutModel extends Model {

    public function __construct()
    {
        $table = ABOUT_TABLE;
        parent::__construct($table);
    }

    public static function wildcardLike($var) {
        return '%'.$var.'%';
    }

    public function searchAbout($keyword, $orderBy = 'id', $order, $limit, $offset) {
        if ($keyword == '') {
            return $this->findAll([
                'order' => $orderBy.' '.$order,
                'limit' => $limit,
                'offset' => $offset
            ]);
        } else {
            return  $this->findAll([
                'conditions' => "(`alias` LIKE ? OR `title` LIKE ?)",
                'bind' => [self::wildcardLike($keyword),self::wildcardLike($keyword)],
                'order' => 'id '.$order,
                'limit' => $limit,
                'offset' => $offset
            ]);
        }
        
    }

    public function countMatchedAbout($keyword) {
        if($keyword != '') {
            return $this->countMatched([
                'conditions' => "(`alias` LIKE ? OR `title` LIKE ?)",
                'bind' => [self::wildcardLike($keyword),self::wildcardLike($keyword)]
            ]);
        } else {
            return 0;
        }
    }

    public function countAbout() {
        return $this->countRows();
    }

}