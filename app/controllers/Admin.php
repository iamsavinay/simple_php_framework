<?php

class Admin extends Controller {
    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('AdminsModel');
    }

    public function indexAction(){
        $this->view->userinfo = Helper::currentUser();
        $this->view->render('admin/index');
    }

    public function userAction($param = '', $act = '') {
        if ($param == '') {
            // manage users
            $query = '';
            $userData = [];

            $query = (!empty(Input::get('q'))) ? Input::get('q') : '';
            // is_int() check failing -- temporarily removing :: fixed -> is_numeric()
            $pageIndex = (!empty(Input::get('p')) && is_numeric(Input::get('p'))) ? ((int)Input::get('p')) : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            $userData = $this->AdminsModel->searchUsers($query, ($pageIndex-1)*20);
            
            $this->view->query = $query;
            $this->view->pageindex = $pageIndex;
            $this->view->userdata = $userData;
            $this->view->usercount = $this->AdminsModel->countUsers();
            $this->view->render('admin/manageusers');

        } elseif ($param == 'add') {
            // add new user

            $this->view->render('admin/adduser');

        } elseif (is_numeric($param)) {
            // edit user data
            if ($act == '') {
                Router::redirect('admin/user/'.$param.'/change');
            } elseif ($act == 'change') {
                // change user details form
                $validation = new Validate();
                $userData = $this->AdminsModel->getUser($param);
                if(!empty($userData)) {
                    $userId = $userData->id;
                    $posted_values = [
                        'fname' => $userData->fname,
                        'lname' => $userData->lname,
                        'email' => $userData->email,
                        'username' => $userData->username,
                        'password' => '',
                        'confirm' => '',
                        'dob' => $userData->dob,
                        'gender' => $userData->gender,
                        'picture' => $userData->picture
                    ];
                    $role_data = json_decode(file_get_contents(ROLE_FILE) ,true);
                    // get roles from the file
                    $roles =[];
                    foreach ($role_data as $key => $value) {
                        $roles[] = $key;
                    }
                    $userroles = json_encode($userData->roles, true);
                    
                    if($_POST) {
                        // Helper::dnd($_POST);

                        $posted_values = Input::posted_values($_POST);
                        $validation->check($posted_values, [
                            'fname' => [
                                'display' => 'First Name',
                            ],
                            'lname' => [
                                'display' => 'Last Name',
                            ],
                            'username' => [
                                'display' => 'Username',
                                'required' => true,
                                'min' => 6,
                                'max' => 150
                            ],
                            'email' => [
                                'display' => 'Email',
                                'required' => true,
                                'max' => 150,
                                'valid_email' => true
                            ],
                            'password' => [
                                'display' => 'Password',
                                'min' => 6,
                            ],
                            'confirm' => [
                                'display' => 'Confirm Password',
                                'matches' => 'password'
                            ],
                            'dob' => [
                                'display' => 'Date of Birth',
                                'max' => 150
                            ]
                        ]);

                        if($validation->passed()) {
                            $user = new UsersModel($param);
                            $user->adminUpdateUser($posted_values);
                            Router::redirect('admin/user');
                        }
                    }
                    $this->view->roles = $roles;
                    $this->view->userroles = json_decode($userData->roles, true);
                    $this->view->userpicture = $userData->picture;
                    $this->view->userid = $userId;
                    $this->view->userdata = $posted_values;
                    $this->view->displayErrors = $validation->displayErrors();
                    $this->view->render('admin/edituser');

                } else {
                    Router::redirect('errorHandler');
                }

            } elseif ($act == 'delete') {
                $userData = $this->AdminsModel->getUser($param);
                if(!empty($userData)) {
                    
                    if($_POST) {
                        if(!empty(Input::get('id')) && !empty(Input::get('username'))) {
                            if(Input::get('id') == $userData->id && Input::get('username') == $userData->username) {
                                $userData->enablePermDelete();
                                $userData->delete();
                                echo "success";
                                Router::redirect('admin/user');
                            }
                        } else echo "error";
                    } else {
                        $this->view->userdata = $userData;
                        $this->view->render('admin/deleteuser');
                    }
                    
                } else {
                    $this->view->render('errorHandler/index');
                }
            } elseif ($act == 'changeimage') {
                if($_POST) {
                    $userData = $this->AdminsModel->getUser($param);
                    if(!empty($userData)) {
                        $userId = $userData->id;
                        $data = explode('base64,' , Input::get('image'))[1];
                        
                        do {
                        $filename = 'pimg'.uniqid().'$'.$userId.'.png';
                        } while(file_exists(ROOT.'/img/profile/'.$filename));
                        
                        file_put_contents(ROOT.'/img/profile/'.$filename, base64_decode($data));
                        
                        $user = new UsersModel($param);
                     
                        $user->picture = $filename;
                        $user->save();

                        header('Content-Type:json/application');
                        echo json_encode([
                            "status" => 'success',
                            "imgurl" => PIROOT.$filename
                        ]);


                    }
                    
                }
            }

            
        }
    }
}