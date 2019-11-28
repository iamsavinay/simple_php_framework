<?php

class About extends Controller{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }

    public function indexAction(){
        echo "About Index";
    }

    public function aboutusAction(){
        echo "About About";
    }

    public function privacyAction(){
        echo "About Privacy";
    }

}