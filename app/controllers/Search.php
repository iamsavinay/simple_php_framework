<?php

class Search extends Controller{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }

    public function indexAction(){
        echo "This is search page.";
    }

}