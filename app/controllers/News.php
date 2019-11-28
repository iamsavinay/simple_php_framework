<?php

class News extends Controller{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->load_model('NewsModel');
    }

    public function indexAction(){
        $this->view->render('news/index');
    }

    public function newsAction($param = ''){
        if($param != ''){
            $news = $this->NewsModel->getNews($param);
            if($news){
                $this->view->resultdata = $news;
                $this->view->render('news/news');
            } else {
                $this->view->render('errorHandler/index');
            }
        } else {
            $this->view->render('errorHandler/index');
        }
    }

    
}