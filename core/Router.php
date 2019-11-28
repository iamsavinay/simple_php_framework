<?php

class Router {
  public static function route($uri) {
    // cleaning of url
    $query = strpos($uri, '?');
    $hash = strpos($uri, '#');
    if($query !== FALSE || $hash !== FALSE){
      $idx =  $query < $hash ? $hash : $query;
      $uri = substr($uri, 0, $idx);
    }

    $uri = ($uri != '') ? explode('/', $uri) : [];

    // controllers
    $controller = (isset($uri[0]) && $uri <> '') ? ucwords($uri[0]) : DEFAULT_CONTROLLER;
    $controller_name = $controller;
    array_shift($uri);

    // action
    $action = (isset($uri[0]) && $uri <> '') ? $uri[0] . 'Action' : 'indexAction';
    $action_name = (isset($uri[0]) && $uri[0] != '') ? $uri[0] : 'index';
    array_shift($uri);


    // check route_existance
    $routeExists = self::checkRouteExistance($controller, $action);
    if(!$routeExists) {
      $controller_name = $controller = ERROR_HANDLER;
      $action = 'indexAction';
    }

    //access check
    $grantAccess = self::hasAccess($controller_name, $action_name);
    if($routeExists && !$grantAccess) {
      $controller_name = $controller = ACCESS_RESTRICTED;
      $action = "indexAction";
    }

    //parameters from the $uri
    $queryParams = $uri;

    // dispatching the request to the respected controller
    $dispatch = new $controller($controller_name, $action);
    call_user_func_array([$dispatch, $action], $queryParams);
  }

  public static function checkRouteExistance($controller, $action) {
    if (class_exists($controller) && method_exists($controller, $action)) {
      return true;
    }
    return false;
  }

  public static function redirect($location) {
    if(!headers_sent()) {
      header('Location: '.PROOT.$location);
    } else {
      echo '<script type="text/javascript">';
      echo 'window.location.href="'.PROOT.$location.'";';
      echo '</script>';
      echo '<noscript>';
      echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
      echo '</noscript>';exit;
    }
  }

  public static function hasAccess($controller_name, $action_name) {
    $acl_file = file_get_contents(ROOT.'/config/acl.json');
    $acl = json_decode($acl_file, true);
    $current_user_roles = ["guest"];
    $grantAccess = false;


    // // check for loggedin status
    if(Session::exists(CURRENT_USER_SESSION_NAME)) {
      $current_user_roles[] = "user";
      foreach(Helper::currentUser()->roles() as $a) {
        $current_user_roles[] = $a;
      }
    }

    // -- check for allowed
    foreach($current_user_roles as $role) {
      if(array_key_exists($role, $acl)) {
        $allowed = $acl[$role]['allowed'];
        if(array_key_exists($controller_name, $allowed)) {
          if(in_array($action_name, $allowed[$controller_name]) || in_array("*", $allowed[$controller_name])) {
            $grantAccess = true;
            break;
          }
        }
      }
    }

    // -- check for denied

    if($grantAccess == true) {
      foreach ($current_user_roles as $role) {
        $denied = $acl[$role]['denied'];
        if(!empty($denied) && array_key_exists($controller_name, $denied)) {
          if(in_array($action_name, $denied[$controller_name]) || in_array("*", $denied[$controller_name])) {
            $grantAccess = false;
            break;
          }
        }
      }
    }

    // -- check for special permissions
    //  using the perms()
    //  need to be implemented
        
    return $grantAccess;
  }

  public static function getMenu($menu) {
    $menuFile = file_get_contents(ROOT.'/config/'.$menu.'.json');
    $acl = json_decode($menuFile, true);
    $menuArr = self::getLinks($acl);
    return $menuArr;
  }

  // recursive function - to get links
  private static function getLinks($arr, $key = ''){
    $returnArray = [];
    foreach($arr as $key => $value){
      if(is_array($value)){
        $returnArray[$key] = self::getLinks($value, $key);
        if(empty($returnArray[$key])){
          unset($returnArray[$key]);
        }
      } else {
        $tmp = self::get_link($value);
        if($tmp != false){
          $returnArray[$key] = $tmp;
        }
      }
    }
    return $returnArray;
  }

  private static function get_link($val) {
    // echo "Called";
    // check if it is an external link
    if(preg_match('/https?:\/\//', $val) == 1) {
      return $val;
    } else {
      $uAry = explode('/', $val);
      $controller_name = ucwords($uAry[0]);
      $action_name = (isset($uAry[1])) ? $uAry[1] : '';
      if(self::hasAccess($controller_name, $action_name)) {
        return PROOT.$val;
      }
      return false;
    }
  }

  public static function getExtendedMenu($menu) {
    $menuArr = [];
    $menuFile = file_get_contents(ROOT.'/config/'.$menu.'.json');
    $menuList = json_decode($menuFile, true);
    // dnd($acl);
    
    foreach ($menuList as $ka => $va) {
      if(is_array($va)) {
        $temp1 = [];
        foreach ($va as $kb => $vb) {
          if(is_array($vb)) {
            $temp2 = [];
            foreach ($vb as $kc => $vc) {
              // ---
              if(is_array($vc)) {
                $temp3 = [];
                foreach ($vc as $kd => $vd) {
                  if(is_array($vd)) {
                    $temp4 = [];
                    foreach ($vd as $ke => $ve) {
                      if($finalVal = self::get_link($ve)) {
                        $temp4[$ke] = $finalVal;
                      }
                    }
                    if (!empty($temp4)) {
                      $temp3[$kd] = $temp4;
                    }
                  } else {
                    if($finalVal = self::get_link($vd)){
                      $temp3[$kd] = $finalVal;
                    }
                  }
                }
                if (!empty($temp3)) {
                  $temp2[$kc] = $temp3;
                }
              } else {
                if($finalVal = self::get_link($vc)){
                  $temp2[$kc] = $finalVal;
                }
              }
            }
            if (!empty($temp2)) {
              $temp1[$kb] = $temp2;
            }
          } else {
            if($finalVal = self::get_link($vb)){
              $temp1[$kb] = $finalVal;
            }
          }
        }
        if (!empty($temp1)){
          $menuArr[$ka] = $temp1;
        }
      } else {
        if($finalVal = self::get_link($va)){
          $menuArr[$ka] = $finalVal;
        }
      }
    }

    return $menuArr;
  }

}

