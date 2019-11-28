<?php

class Plugins extends Controller {
    
    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }

    public function indexAction($param){
        die();
    }

    public function filemanagerAction($param = '') {
        if ($param == 'connector') {
            if(file_exists(ROOT.'/include/plugins/elfinder/php/autoload.php')) {
                require_once(ROOT.'/include/plugins/elfinder/php/autoload.php');

                elFinder::$netDrivers['ftp'] = 'FTP';


                function access($attr, $path, $data, $volume, $isDir, $relpath) {
                    $basename = basename($path);
                    return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
                             && strlen($relpath) !== 1           // but with out volume root
                        ? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
                        :  null;                                 // else elFinder decide it itself
                }

                $opts = array(
                    // 'debug' => true,
                    'roots' => array(
                        // Items volume
                        array(
                            'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
                            'path'          => ROOT.'/files/',              // path to files (REQUIRED)
                            'URL'           => PROOT.'files/',              // URL to files (REQUIRED)
                            'alias'         => PROOT.'files/',              // fix: to pass absolute url
                            'trashHash'     => 't1_Lw',                     // elFinder's hash of trash folder
                            'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                            'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                            'uploadAllow'   => array('image/x-ms-bmp', 'image/gif', 'image/jpeg', 'image/png', 'image/x-icon', 'text/plain'), // Mimetype `image` and `text/plain` allowed to upload
                            'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
                            'accessControl' => 'access'                     // disable and hide dot starting files (OPTIONAL)
                        ),
                        // Trash volumes
                        array(
                            'id'            => '1',
                            'driver'        => 'Trash',
                            'path'          => ROOT.'files/.trash/',
                            'tmbURL'        => PROOT.'files/.trash/.tmb/',
                            'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                            'uploadDeny'    => array('all'),                // Recomend the same settings as the original volume that uses the trash
                            'uploadAllow'   => array('image/x-ms-bmp', 'image/gif', 'image/jpeg', 'image/png', 'image/x-icon', 'text/plain'), // Same as above
                            'uploadOrder'   => array('deny', 'allow'),      // Same as above
                            'accessControl' => 'access',                    // Same as above
                        )
                    )
                );

                $connector = new elFinderConnector(new elFinder($opts));
                $connector->run();
            }
        } 
    }

}
