<?php

//define the root Directory
define('ROOT', dirname(__FILE__));

// load the Config
require_once(ROOT.'/config/config.php');

// autoload Classes when required
function autoload($classname) {
  if(file_exists(ROOT.'/core/'.$classname.'.php')) {
    require_once(ROOT.'/core/'.$classname.'.php');
  } elseif(file_exists(ROOT.'/app/controllers/'.$classname.'.php')) {
    require_once(ROOT.'/app/controllers/'.$classname.'.php');
  } elseif(file_exists(ROOT.'/app/models/'.$classname.'.php')) {
    require_once(ROOT.'/app/models/'.$classname.'.php');
  } else {
    // remove line below after debugging
    // echo "Error: Requested Class file not found. <br />";
  }
}

// chain the autoload function with new sql autoload
spl_autoload_register('autoload');

// start the session
session_name(SESSION_NAME);
session_start();

// process the urldecode
$uri = (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') ? trim($_SERVER['REQUEST_URI'], '/') : '';


$db = DB::getInstance();

// checks if user previously loggedin with (remember me) button
if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
  UsersModel::loginUserFromCookie();
}

// route the Request
Router::route($uri);