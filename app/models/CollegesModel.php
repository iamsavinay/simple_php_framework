<?php

class CollegesModel extends Model {

    public function __construct($table = COLLEGES_TABLE)
    {
        // $table = COLLEGES_TABLE;
        parent::__construct($table);
    }

    public static function wildcardLike($var) {
        return '%'.$var.'%';
    }

    public function searchColleges($keyword, $orderBy = 'id', $order, $limit, $offset) {
        if ($keyword == '') {
            $orderBy = 'id';
            return $this->findAll([
                'order' => $orderBy.' '.$order,
                'limit' => $limit,
                'offset' => $offset
            ]);
        } else {
            if(is_numeric($keyword)) {
                return  $this->findAll([
                    'conditions' => "(`id` = ?)",
                    'bind' => [$keyword],
                    'order' => 'id '.$order,
                    'limit' => $limit,
                    'offset' => $offset
                ]);
            } else {
                return  $this->findAll([
                    'conditions' => "(`alias` LIKE ? OR `name` LIKE ? OR `aka` LIKE ?)",
                    'bind' => [self::wildcardLike($keyword),self::wildcardLike($keyword),self::wildcardLike($keyword)],
                    'order' => 'id '.$order,
                    'limit' => $limit,
                    'offset' => $offset
                ]);
            }
        }
        
    }

    public function countMatchedColleges($keyword) {
        if($keyword != '') {
            if(is_numeric($keyword)) {
                return $this->countMatched([
                    'conditions' => "(`id` = ?)",
                    'bind' => [$keyword]
                ]);
            } else {
                return $this->countMatched([
                    'conditions' => "(`alias` LIKE ? OR `name` LIKE ? OR `aka` LIKE ?)",
                    'bind' => [self::wildcardLike($keyword),self::wildcardLike($keyword),self::wildcardLike($keyword)]
                ]);
            }
        } else {
            return 0;
        }
    }

    public function countColleges() {
        return $this->countRows();
    }

    public function getCollege($id) {
        return $this->findByID($id);
    }


    public function updateCollege($values){
        $this->assign($values);
        // the assign function was
        //  sanitinzing the html input which we dont want 
        // so we are bypassing it by reassigning the content
        // $this->content = $values['content'];
        if($this->save()){
            return true;
        }
    }

    public function addCollege($values){
        $this->assign($values);
        if($this->save()){
            return true;
        }
    }

    public function getCollegeByAlias($alias){
        $college = $this->findFirst([
            'conditions' => "(`alias` = ?)",
            'bind' => [$alias]
        ]);
        if(!empty($college) && !empty($college->alias)) {
            return $college;
        } else {
            return false;
        }
    }

}