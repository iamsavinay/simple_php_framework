<?php

class UsersModel extends Model{
  private $_isLoggedIn, $_sessionName, $_cookieName;
  public static $currentLoggedInUser = null;

  public function __construct($user = '') {
    $table = USERS_TABLE;
    parent::__construct($table);
    $this->_sessionName = CURRENT_USER_SESSION_NAME;
    $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
    $this->_softDelete = true;
    if ($user != '') {
      if(is_numeric($user)) {
        $u = $this->_db->findFirst($table, [
          "conditions" => "id = ?",
          "bind" => [$user]
        ]);
      } else {
        $u = $this->_db->findFirst($table, [
          "conditions" => "username = ?",
          "bind" => [$user]
        ]);
      }
      if($u) {
        foreach($u as $key => $value) {
          $this->$key = $value;
        }
      }
    }
  }

  public function findByUsername($username) {
    // if ($username == '') return false;
    $user = $this->findFirst([
      "conditions" => "username = ?",
      "bind" => [$username]
    ]);
    return $user;
  }

  public function findByEmail($email) {
    // if ($email == '') return false;
    $user = $this->findFirst([
      'conditions' => "email = ?",
      'bind' => [$email]
    ]);
    return $user;
  }

  public function findByID($id) {
    // if ($email == '') return false;
    $user = $this->findFirst([
      'conditions' => "id = ?",
      'bind' => [$id]
    ]);
    return $user;
  }

  public static function CurrentLoggedInUser() {
    if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
      $u = new UsersModel((int)Session::get(CURRENT_USER_SESSION_NAME));
      self::$currentLoggedInUser = $u;
    }
    return self::$currentLoggedInUser;
  }

  public function login($rMe = false) {
    if($this->disable == '1') return false;
    Session::set($this->_sessionName, $this->id);
    if ($rMe) {
      $hash = md5(uniqid().rand(0, 100));
      $user_agent = Session::uagent_no_version();
      Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
      $fields = [
        'session' => $hash,
        'user_agent' => $user_agent,
        'user_id' => $this->id
      ];
      $this->_db->query("DELETE FROM ".USER_SESSIONS_TABLE." WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
      $this->_db->insert(USER_SESSIONS_TABLE, $fields);
    }
    return true;
  }

  public static function loginUserFromCookie() {
    $userSession = UserSessionsModel::getFromCookie();
    if($userSession->user_id != '') {
      $user = new self((int)$userSession->user_id);
    }
    if($user) {
      $user->login();
    }
    return $user;
  }

  public function logout() {
    $userSession = UserSessionsModel::getFromCookie();
    if($userSession) $userSession->delete();
    Session::delete(CURRENT_USER_SESSION_NAME);
    if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
      Cookie::delete(REMEMBER_ME_COOKIE_NAME);
    }
    self::$currentLoggedInUser = null;
    return true;
  }

  public function registerNewUser($params) {
    $this->assign($params);
    $this->disabled = 0;
    $this->created = date("d-m-Y H:i:s");
    //making the acl empty for every new registered user (just a security concern)
    $this->roles = '';
    $this->perms = '';
    $this->is_superuser = '';
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    $this->save();
  }

  public function adminUpdateUser($params) {
    
    $this->fname = $params['fname'];
    $this->lname = $params['lname'];
    $this->email = $params['email'];
    $this->gender = $params['gender'];

    $this->modified = date("d-m-Y H:i:s");
    
    // if there is password in params then update the password
    if(!empty($params['password']) && $params['password'] != ''){
      $this->password = password_hash($params['password'], PASSWORD_DEFAULT);
    }

    $this->roles = (!empty($params['roles'])) ? json_encode($params['roles']) : '';
    $this->perms = (!empty($params['perms'])) ? json_encode($params['perms']) : '';

    $this->disable = (!empty($params['disable']) && $params['disable'] == 'on') ? 1 : 0;
    $this->is_superuser = (!empty($params['is_superuser']) && $params['is_superuser'] == 'on') ? 1 : 0;
    
    $this->save();
  }

  // public function acls() {
  //   if(empty($this->acl)) return [];
  //   return json_decode($this->acl, true);
  // }

  public function roles() {
    if(empty($this->roles)) return [];
    return json_decode($this->roles, true);
  }
  
  public function perms() {
    if(empty($this->perms)) return [];
    return json_decode($this->perms, true);
  }

  public function countUsers() {
    return $this->countRows();
  }
}
