<?php

class Output {

    public static function html($encoded) {
        if(is_array($encoded)) {
          return self::htmlDecodeArray($encoded);
        }
        return html_entity_decode($encoded, ENT_QUOTES, "UTF-8");
    }
      
    
    public static function htmlDecodeArray(array &$array, $filter = true) {
      array_walk_recursive($array, function (&$value) use ($filter) {
        $value = trim($value);
        if ($filter) {
          // we can also use 
          // htmlentities($dirty, ENT_QUOTES, "UTF-8");
          $value = html_entity_decode($dirty, ENT_QUOTES, "UTF-8");
        }
      });
      return $array;
    }
    
}