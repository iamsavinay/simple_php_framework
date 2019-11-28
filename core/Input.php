<?php

class Input {
  public static function sanitize($dirty) {
    if(is_array($dirty)) {
      return self::sanitizeArray($dirty);
    }
    // return htmlentities($dirty, ENT_QUOTES, "UTF-8");
    return filter_var($dirty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }
  

  public static function sanitizeArray(array &$array, $filter = true) {
    array_walk_recursive($array, function (&$value) use ($filter) {
      // $value = trim($value);
      if ($filter) {
        // we can also use 
        $value = htmlentities($value, ENT_QUOTES, "UTF-8");
        // $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      }
    });
    return $array;
  }


  public static function get($input) {
    if (isset($_POST[$input])) {
      return self::sanitize($_POST[$input]);
    } else if (isset($_GET[$input])) {
      return self::sanitize($_GET[$input]);
    }
  }
  
  public static function getRaw($input) {
    if (isset($_POST[$input])) {
      return $_POST[$input];
    } else if (isset($_GET[$input])) {
      return $_GET[$input];
    }
  }

  public static function posted_values($post) {
    $clean_ary = [];
    foreach ($post as $key => $value) {
      $clean_ary[$key] = self::sanitize($value);
    }
    return $clean_ary;
  }

  public static function getGet($input) {
    if (isset($_GET[$input])) {
      return self::sanitize($_GET[$input]);
    }
  }

  public static function getPost($input) {
    if (isset($_POST[$input])) {
      return self::sanitize($_POST[$input]);
    }
  }
}
