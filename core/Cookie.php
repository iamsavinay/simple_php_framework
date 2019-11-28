<?php

class Cookie {

  public static function set($name, $value, $expiry) {
    if(setcookie($name, $value, (int)(time() + $expiry), '/')) {
     return true;
    }
    return false;
  }

  public static function delete($name) {
    if(self::set($name, '', time() - 1)) {
      return true;
    }
    return false;
  }

  public static function get($name) {
    return $_COOKIE[$name];
  }

  public static function exists($name) {
    return isset($_COOKIE[$name]);
  }
}
