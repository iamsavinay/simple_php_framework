<?php 

class Contentman extends Controller {

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action); 
    }

    public function indexAction() {
        $this->view->render('contentman/index');

    }

    public function newsAction($param = '', $act = '') {
        
        // loading model
        $this->load_model('NewsModel');
        
        // checking for parameters
        if($param == '' ) {

            // getting GET parameters
            $q = Input::get('q');
            $l = Input::get('l');
            $p = Input::get('p');

            // analysing GET parameters
            $query = (!empty($q)) ? $q : '';
            $fetchLimit = (!empty($l) && is_numeric($l)) ? (int)$l : 20;
            $pageIndex = (!empty($p) && is_numeric($p)) ? (int)$p : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            //fetching the data from the database
            $resultData = $this->NewsModel->searchNews($query, 'id','DESC', $fetchLimit, ($pageIndex-1)*$fetchLimit);
            $countMatched = $this->NewsModel->countMatchedNews($query);
            $totalRows = $this->NewsModel->countNews(); 
            
            // assigning values to view object
            $this->view->query = $query;
            $this->view->fetchlimit = $fetchLimit;
            $this->view->pageindex = $pageIndex;
            $this->view->resultdata = $resultData;
            $this->view->matchedresults = $countMatched;
            $this->view->totalresults = $totalRows;

            $this->view->render('contentman/newsman');

        } elseif($param == 'ajaxnews') {
            
            $q = Input::get('q');
            $l = Input::get('l');
            $p = Input::get('p');
            

            $query = (!empty($q)) ? $q : '';
            $fetchLimit = (!empty($l) && is_numeric($l)) ? (int)$l : 10;
            $pageIndex = (!empty($p) && is_numeric($p)) ? (int)$p : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            $resultData = $this->NewsModel->searchNews($query, 'id','ASC', $fetchLimit, 0);
            $arr['totalResults'] = $this->NewsModel->countMatchedNews($query);
            $arr['results'] = $resultData;
            
            // removing the unnecessary data from the array
            // $arr = array_slice($resultData, 0, 3);

            header('ContentType: application/json');
            echo json_encode($arr);

        } elseif ($param == 'add'){

            // add new entry
            if($_POST) {
                $action = Input::get('action');
                if($action == 'add') {
                    header("Content-Type: application/json");                    
                    if(Input::get('title') == '' || Input::get('alias') == '') {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Field(s) are empty.'
                        ]);
                        die();
                    }

                    $par = [
                        'title' => Input::get('title'),
                        'alias' => Input::get('alias'),
                        'category' => '',
                        'desc' => '',
                        'content' => '',
                        'parent' => 0,
                        'priority' => 'DEFAULT',
                        'tags' => '',
                        'related_colleges' => '',
                        'related_exams' => '',
                        'related_jobs' => '',
                        'status' => 'I',
                    ];

                    // check if the news with same alias exists
                    $n = $this->NewsModel->getNewsByAlias($par['alias']);
                    if($n) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Duplicate Entry! Entry already Exists.'
                        ]);
                    } else {
                        if($this->NewsModel->addNews($par)) {
                            $newsID = $this->NewsModel->lastID();
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'News Added...',
                                'id' => $newsID
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Unknown Error happened'
                            ]);
                        }
                    }

                }

            }
            

        } elseif (is_numeric($param)) {
            
            if ($act == '') {
                Router::redirect('contentman/news/'.$param.'/edit');
            } elseif ($act == 'edit') {

                // check for existance in database
                $news = $this->NewsModel->getNews($param);
                if (!empty($news)) {
                    
                    
                    // hadling post requests
                    if($_POST) {
                        
                        $a = Input::get('action');
                        $returnString = '';

                        $posted_values = [
                            'id' => $param,
                            'title' => Input::get('title'),
                            'alias' => Input::get('alias'),
                            'category' => Input::get('category'),
                            'desc' => Input::get('desc'),
                            'content' => $_POST['content'],
                            'parent' => Input::get('parent'),
                            'priority' => Input::get('priority'),
                            'tags' => json_encode(Input::get('tags')),
                            'related_colleges' => json_encode(Input::get('related_colleges')),
                            'related_exams' => json_encode(Input::get('related_exams')),
                            'related_jobs' => json_encode(Input::get('related_jobs')),
                            'status' => Input::get('status'),
                        ];

                        // Helper::dump($_POST['content']);
                        // Helper::dump($posted_values['content']);

                        if ($a == 'save') {
                            $posted_values['modified_by'] = Helper::currentUser()->id;
                            $posted_values['modified_date'] = date(DATE_FORMAT);
                            $returnString = 'saved';
                        } elseif($a == 'publish') {
                            if($news->published != 1) {
                                $posted_values['published'] = 1;
                                $posted_values['published_by'] = Helper::currentUser()->id;
                                $posted_values['published_date'] = date(DATE_FORMAT);    
                                $posted_values['modified_by'] = Helper::currentUser()->id;
                                $posted_values['modified_date'] = date(DATE_FORMAT);
                                $returnString = 'published';    
                            }
                        }

                        if($this->NewsModel->updateNews($posted_values)) {
                            echo $returnString;
                        } else {
                            echo 'error';
                        }
                    } else {
                        // edit news
                        $this->view->userdata = Helper::currentUser();
                        $this->view->profileimg = Helper::getProfileImgLink($this->view->userdata->picture);
                        $this->view->resultdata = $news;
                        $this->view->render('contentman/newsedit');
                    }


                } else {
                    $this->view->render('errorHandler/index');
                }

            } elseif($act == 'delete') {
                
                //delete news                
                $news = $this->NewsModel->getNews($param);
                if($news && $news->id == $param) {
                    if($_POST) {
                        $id = Input::get('id');
                        if($news->id == $id) {
                            $news->enablePermDelete();
                            $news->delete();
                            Router::redirect('contentman/news');
                        } else {
                            $this->view->resultdata = $news;                            
                            $this->view->render('contentman/newsdelete');
                        }
                    } else {
                        $this->view->resultdata = $news;
                        $this->view->render('contentman/newsdelete');
                    }
                }
                
            } else {
                $this->view->render('errorHandler/index');
            }

        }
    }

    public function collegeAction($param = '', $act = '') {
        
        // loading model
        $this->load_model('CollegesModel');
        
        // checking for parameters
        if($param == '' ) {

            // getting GET parameters
            $q = Input::get('q');
            $l = Input::get('l');
            $p = Input::get('p');

            // analysing GET parameters
            $query = (!empty($q)) ? $q : '';
            $fetchLimit = (!empty($l) && is_numeric($l)) ? (int)$l : 20;
            $pageIndex = (!empty($p) && is_numeric($p)) ? (int)$p : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            //fetching the data from the database
            $resultData = $this->CollegesModel->searchColleges($query, 'name','ASC', $fetchLimit, ($pageIndex-1)*$fetchLimit);
            $countMatched = $this->CollegesModel->countMatchedColleges($query);
            $totalRows = $this->CollegesModel->countColleges(); 
            
            // assigning values to view object
            $this->view->query = $query;
            $this->view->fetchlimit = $fetchLimit;
            $this->view->pageindex = $pageIndex;
            $this->view->resultdata = $resultData;
            $this->view->matchedresults = $countMatched;
            $this->view->totalresults = $totalRows;

            $this->view->render('contentman/collegeman');
        } elseif($param == 'ajaxcollege') {
            
            $q = Input::get('q');
            $l = Input::get('l');
            $p = Input::get('p');
            

            $query = (!empty($q)) ? $q : '';
            $fetchLimit = (!empty($l) && is_numeric($l)) ? (int)$l : 10;
            $pageIndex = (!empty($p) && is_numeric($p)) ? (int)$p : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            $resultData = $this->CollegesModel->searchColleges($query, 'id','DESC', $fetchLimit, 0);
            $arr['totalResults'] = $this->CollegesModel->countMatchedColleges($query);
            $arr['results'] = $resultData;

            header('Content-Type: application/json');
            echo json_encode($arr);

        } elseif ($param == 'ajaxCDcollege') {
            $q = Input::get('q');
            $l = Input::get('l');
            $p = Input::get('p');
            

            $query = (!empty($q)) ? $q : '';
            $fetchLimit = (!empty($l) && is_numeric($l)) ? (int)$l : 20;
            $pageIndex = (!empty($p) && is_numeric($p)) ? (int)$p : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            $this->load_model('CdCollegesModel');

            $resultData = $this->CdCollegesModel->searchColleges($query, 'name','ASC', $fetchLimit, 0);
            $arr['totalResults'] = $this->CdCollegesModel->countMatchedColleges($query);
            $arr['results'] = $resultData;

            header('Content-Type: application/json');
            echo json_encode($arr);

        } elseif ($param == 'ajaxCPcollege') {
            $q = Input::get('q');
            $l = Input::get('l');
            $p = Input::get('p');
            

            $query = (!empty($q)) ? $q : '';
            $fetchLimit = (!empty($l) && is_numeric($l)) ? (int)$l : 20;
            $pageIndex = (!empty($p) && is_numeric($p)) ? (int)$p : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            $this->load_model('CpCollegesModel');

            $resultData = $this->CpCollegesModel->searchColleges($query, 'name','ASC', $fetchLimit, 0);
            $arr['totalResults'] = $this->CpCollegesModel->countMatchedColleges($query);
            $arr['results'] = $resultData;

            header('Content-Type: application/json');
            echo json_encode($arr);

        } elseif ($param == 'add'){

            // add new entry
            if($_POST) {
                $action = Input::get('action');
                if($action == 'add') {
                    header("Content-Type: application/json");                    
                    if(Input::get('name') == '' || Input::get('alias') == '') {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Field(s) are empty.'
                        ]);
                        die();
                    }

                    $par = [
                        'name' => Input::get('name'),
                        'alias' => Input::get('alias'),
                    ];

                    // check if the news with same alias exists
                    $n = $this->CollegesModel->getCollegeByAlias($par['alias']);
                    if($n) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Duplicate Entry! Entry already Exists.'
                        ]);
                    } else {
                        if($this->CollegesModel->addCollege($par)) {
                            $collegeID = $this->CollegesModel->lastID();
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'College Added...CollegeID: '.$collegeID,
                                'id' => $collegeID
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Unknown Error happened'
                            ]);
                        }
                    }

                }

            }
            


        } elseif ($param == 'update'){

            //update the news
            if($_POST && Input::get('action') == 'updateparent') {

                $id = Input::get('id');
                $par = Input::get('parent');

                if(empty($id) || empty($par) || !is_numeric($id) || !is_numeric($par)) {
                    die();
                }

                $college = $this->CollegesModel->getCollege($id);

                $params = [
                    'parent' => $par
                ];

                if($college) {
                    if($college->updateCollege($params)) {
                        echo 'success';
                    }
                }

            }

            if($_POST && Input::get('action') == 'updateCD') {

                $this->load_model('CdCollegesModel');

                $id = Input::get('id');
                $newID = Input::get('newID');

                if(empty($id) || empty($newID) || !is_numeric($id) || !is_numeric($newID)) {
                    die();
                }

                $college = $this->CdCollegesModel->getCollege($id);

                $params = [
                    'new_id' => $newID,
                    'edited' => 1
                ];

                if($college) {
                    if($college->updateCollege($params)) {
                        echo 'success';
                    }
                }

            }

            if($_POST && Input::get('action') == 'updateCP') {

                $this->load_model('CpCollegesModel');

                $id = Input::get('id');
                $newID = Input::get('newID');

                if(empty($id) || empty($newID) || !is_numeric($id) || !is_numeric($newID)) {
                    die();
                }

                $college = $this->CpCollegesModel->getCollege($id);

                $params = [
                    'new_id' => $newID,
                    'edited' => 1
                ];

                if($college) {
                    if($college->updateCollege($params)) {
                        echo 'success';
                    }
                }

            }

        } elseif (is_numeric($param)) {
            
            if ($act == '') {
                Router::redirect('contentman/news/'.$param.'/edit');
            } elseif ($act == 'edit') {
                
            } elseif($act == 'delete') {

            } else {
                $this->view->render('errorHandler/index');
            }

        } 
    }

    public function examAction($param = '', $act = '') {
        
        // loading model
        $this->load_model('ExamsModel');
        
        // checking for parameters
        if($param == '' ) {

            // getting GET parameters
            $q = Input::get('q');
            $l = Input::get('l');
            $p = Input::get('p');

            // analysing GET parameters
            $query = (!empty($q)) ? $q : '';
            $fetchLimit = (!empty($l) && is_numeric($l)) ? (int)$l : 20;
            $pageIndex = (!empty($p) && is_numeric($p)) ? (int)$p : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            //fetching the data from the database
            $resultData = $this->ExamsModel->searchExams($query, 'id','DESC', $fetchLimit, ($pageIndex-1)*$fetchLimit);
            $countMatched = $this->ExamsModel->countMatchedExams($query);
            $totalRows = $this->ExamsModel->countExams(); 
            
            // assigning values to view object
            $this->view->query = $query;
            $this->view->fetchlimit = $fetchLimit;
            $this->view->pageindex = $pageIndex;
            $this->view->resultdata = $resultData;
            $this->view->matchedresults = $countMatched;
            $this->view->totalresults = $totalRows;

            $this->view->render('contentman/examman');

        } elseif ($param == 'add'){

            // add new entry
            

        } elseif (is_numeric($param)) {
            
            if ($act == '') {
                Router::redirect('contentman/exam/'.$param.'/edit');
            } elseif ($act == 'edit') {
                
            } elseif($act == 'delete') {

            } else {
                $this->view->render('errorHandler/index');
            }

        }
    } 

    public function aboutAction($param = '', $act = '') {
        
        // loading model
        $this->load_model('AboutModel');
        
        // checking for parameters
        if($param == '' ) {

            // getting GET parameters
            $q = Input::get('q');
            $l = Input::get('l');
            $p = Input::get('p');

            // analysing GET parameters
            $query = (!empty($q)) ? $q : '';
            $fetchLimit = (!empty($l) && is_numeric($l)) ? (int)$l : 20;
            $pageIndex = (!empty($p) && is_numeric($p)) ? (int)$p : 1;
            $pageIndex = ($pageIndex < 1) ? 1 : $pageIndex;

            //fetching the data from the database
            $resultData = $this->AboutModel->searchAbout($query, 'id','DESC', $fetchLimit, ($pageIndex-1)*$fetchLimit);
            $countMatched = $this->AboutModel->countMatchedAbout($query);
            $totalRows = $this->AboutModel->countAbout(); 
            
            // assigning values to view object
            $this->view->query = $query;
            $this->view->fetchlimit = $fetchLimit;
            $this->view->pageindex = $pageIndex;
            $this->view->resultdata = $resultData;
            $this->view->matchedresults = $countMatched;
            $this->view->totalresults = $totalRows;

            $this->view->render('contentman/aboutman');
        } elseif ($param == 'add'){

            // add new entry
            

        } elseif (is_numeric($param)) {
            
            if ($act == '') {
                Router::redirect('contentman/about/'.$param.'/edit');
            } elseif ($act == 'edit') {
                
            } elseif($act == 'delete') {

            } else {
                $this->view->render('errorHandler/index');
            }

        }
    }

}