<?php

class User extends Controller {
    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('UsersModel');
    }

    public function dashboardAction() {
        $this->view->userinfo = Helper::currentUser();
        $this->view->render('user/dashboard');
    }

    public function logoutAction(){
        if (UsersModel::CurrentLoggedInUser()) {
            UsersModel::CurrentLoggedInUser()->logout();
          }
        Router::redirect('user/login');
    }

    public function loginAction(){
        $validation = new Validate();
        if ($_POST) {
            $validation->check(Input::posted_values($_POST), [
              'username' => [
                'display' => "Username or Email",
                'required' => true
              ],
              'password' => [
                'display' => 'Password',
                'required' => true,
                'min' => 6
              ]
            ]);
      
            if ($validation->passed()) {
              $user = $this->UsersModel->findByUsername(Input::get('username'));
              if($user && $user->username == Input::get('username') && password_verify(Input::get('password'), $user->password)) {
                $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
                $resp = $user->login($remember);
                if($resp == false) {
                    $validation->addError("Unable to login!");    
                } else {
                    Router::redirect('user/dashboard');
                }
              }
              $user = $this->UsersModel->findByEmail(Input::get('username'));
              if($user && $user->email == Input::get('username') && password_verify(Input::get('password'), $user->password)) {
                $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
                $resp = $user->login($remember);
                if($resp == false) {
                    $validation->addError("Unable to login!");    
                } else {
                    Router::redirect('user/dashboard');
                }
              } else {
                $validation->addError("Invalid Username or Password!");
              }
            }
        }
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('user/login');
    }

    public function registerAction(){

        $validation = new Validate();
        $posted_values = [
          'fname' => '',
          'lname' => '',
          'email' => '',
          'username' => '',
          'password' => '',
          'confirm' => ''
        ];
        if($_POST) {
            $posted_values = Input::posted_values($_POST);
            $validation->check($posted_values, [
                'fname' => [
                'display' => 'First Name',
                'required' => true,
                'max' => 150
                ],
                'lname' => [
                'display' => 'Last Name',
                'required' => true,
                'max' => 150
                ],
                'username' => [
                'display' => 'Username',
                'required' => true,
                'unique' => USERS_TABLE,
                'min' => 6,
                'max' => 150
                ],
                'email' => [
                'display' => 'Email',
                'required' => true,
                'unique' => USERS_TABLE,
                'max' => 150,
                'valid_email' => true
                ],
                'password' => [
                'display' => 'Password',
                'required' => true,
                'min' => 6,
                'max' => 150
                ],
                'confirm' => [
                'display' => 'Confirm Password',
                'required' => true,
                'matches' => 'password'
                ]
            ]);
            if ($validation->passed()) {
                // stuff to be done after successfull submition
                $this->UsersModel->registerNewUser($posted_values);
                $user = $this->UsersModel->findByUsername(Input::get('username'));
                if($user && $user->username == Input::get('username') && password_verify(Input::get('password'), $user->password)) {
                $user->login(false);
                Router::redirect('user/dashboard');
                } else {
                Router::redirect('user/login');
                }
            }
        }
        $this->view->post = $posted_values;
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('user/register');
    }
}