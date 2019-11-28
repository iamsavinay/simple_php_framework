<?php

class Helper {

    public static function dump($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    public static function dnd($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        exit();
    }

    public static function currentPage() {
        $cp = $_SERVER['REQUEST_URI'];
        if (empty($cp) || $cp == PROOT || $cp == PROOT.'home') {
          $cp = PROOT.'home';
        }
        return $cp;
    }

    public static function getProfileImglink($val) {
        // check if it is an external link
        if(preg_match('/https?:\/\//', $val) == 1) {
          return $val;
        } else {
          return PROOT.'img/profile/'.$val;
        }
      }

    public static function currentUser() {
        return UsersModel::currentLoggedInUser();
    }

    public static function genRandomString() {
        $length = 10;
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";

        $real_string_length = strlen($characters) ;     
        $string="id";
        
        for ($p = 0; $p < $length; $p++) 
        {
            $string .= $characters[mt_rand(0, $real_string_length-1)];
        }
        return strtolower($string);
    }

}