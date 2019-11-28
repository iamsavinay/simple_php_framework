<?php

class NewsModel extends Model {

    public function __construct()
    {
        $table = NEWS_TABLE;
        parent::__construct($table);
    }

    public static function wildcardLike($var) {
        return '%'.$var.'%';
    }

    public function searchNews($keyword, $orderBy = 'id', $order, $limit, $offset) {
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
                    'conditions' => "(`alias` LIKE ? OR `title` LIKE ?)",
                    'bind' => [self::wildcardLike($keyword),self::wildcardLike($keyword)],
                    'order' => $orderBy.' '.$order,
                    'limit' => $limit,
                    'offset' => $offset
                ]);
            }
        }
        
    }

    public function getNews($id) {
        return $this->findByID($id);
    }

    public function countMatchedNews($keyword) {
        if($keyword != '') {
            if(is_numeric($keyword)) {
                return $this->countMatched([
                    'conditions' => "(`id` = ?)",
                    'bind' => [$keyword]
                ]);
            } else {
                return $this->countMatched([
                    'conditions' => "(`alias` LIKE ? OR `title` LIKE ?)",
                    'bind' => [self::wildcardLike($keyword),self::wildcardLike($keyword)]
                ]);
            }
        } else {
            return 0;
        }
    }

    public function countNews() {
        return $this->countRows();
    }

    public function updateNews($values){
        $this->assign($values);
        // the assign function was
        //  sanitinzing the html input which we dont want 
        // so we are bypassing it by reassigning the content
        // $this->content = $values['content'];
        if($this->save()){
            return true;
        }
    }


    public function addNews($values) {
        $this->assign($values);
        if($this->save()){
            return true;
        }
    }

    public function getNewsByAlias($alias){
        $news = $this->findFirst([
            'conditions' => "(`alias` = ?)",
            'bind' => [$alias]
        ]);
        if(!empty($news) && !empty($news->alias)) {
            return $news;
        } else {
            return false;
        }
    }
}