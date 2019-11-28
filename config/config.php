<?php

define('DEBUG' , true);

define('DB_DRIVER', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'php_framework');
define('DB_USER', 'root');
define('DB_PASS', '');

define('DEFAULT_CONTROLLER', 'Home'); //default controller if there isn't one defined in the url
define('DEFAULT_LAYOUT', 'default_layout'); // default layout if no layout is set

define('SESSION_NAME', 'ctsession');

define('PROOT', '/'); //set this to '/' for live server

define('SITE_TITLE', 'College Talash'); //this is site title if none is set
define('SITE_URL', 'https://collegetalash.com.test/');

define('CURRENT_USER_SESSION_NAME', 'ctsessionid'); //session name for logged user
define('REMEMBER_ME_COOKIE_NAME', 'ctcookie'); //cookie name for logged user
define('REMEMBER_ME_COOKIE_EXPIRY', 2592000); //time in sec for remember me cookie (30 days)

define('ERROR_HANDLER', 'ErrorHandler'); // controller name for handling http errors (404)
define('ACCESS_RESTRICTED', 'AccessRestricted'); //controller name for restricted redirection

define('DEFAULT_MAILER_HOST', 'stmp.gmail.com');
define('DEFAULT_MAILER_PORT', 465);
define('DEFAULT_MAILER_EMAIL', 'example@gmail.com');
define('DEFAULT_MAILER_PASS', 'passwordhere');

//name of tables
define('USERS_TABLE', 'users');
define('USER_SESSIONS_TABLE', 'user_sessions');
define('COLLEGES_TABLE', 'colleges');
define('EXAMS_TABLE', 'exams');
define('NEWS_TABLE', 'news');
define('HEADLINES_TABLE', 'headlines');

define('DEFAULT_FETCH_LIMIT', 20); // the fetch limit for the database
define('PIROOT', PROOT.'img/profile/'); //add a trailing slash... the default image directory
define('DEFAULT_USER_IMG', PROOT.'img/default_user.jpg');
define('IROOT', PROOT.'img/');
define('LOGO_WIDE', PROOT.'img/ct_logo_wide.png');


define('ROLE_FILE', ROOT.'/config/roles.json');

define('DATE_FORMAT', 'd-m-Y H:i:s');
