<?php

class CdCollegesModel extends Model {

    public function __construct($table = 'cd_colleges')
    {
        // $table = COLLEGES_TABLE;
        parent::__construct($table);
    }

    public static function wildcardLike($var) {
        return '%'.$var.'%';
    }

    public function searchColleges($keyword, $orderBy = 'new_id', $order, $limit, $offset) {
        if ($keyword == '') {
            return $this->findAll([
                'order' => $orderBy.' '.$order,
                'limit' => $limit,
                'offset' => $offset
            ]);
        } else {
            if(is_numeric($keyword)) {
                return  $this->findAll([
                    'conditions' => "(`new_id` = ?)",
                    'bind' => [$keyword],
                    'order' => 'id '.$order,
                    'limit' => $limit,
                    'offset' => $offset
                ]);
            } else {
                return  $this->findAll([
                    'conditions' => "(`alias` LIKE ? OR `name` LIKE ? OR `aka` LIKE ? OR `new_id` = ?)",
                    'bind' => [self::wildcardLike($keyword),self::wildcardLike($keyword),self::wildcardLike($keyword), $keyword],
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

}