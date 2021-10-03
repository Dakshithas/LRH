<?php
  // DB Params
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_NAME', 'lrh');

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  // define('URLROOT', 'http://192.168.8.100/projectn');
  define('URLROOT', 'http://localhost/projectn');
  // define('URLROOT', 'http://192.168.1.2/projectn');
  // Site Name
  define('SITENAME', 'LRH-Physiotheraphy Unit');
  // App Version
  define('APPVERSION', '1.0.0');
  
  define('HOME',isset($Session['role'])?$Session['role']:"Users");

  $GLOBALS['config'] = array(
    'mysql' => array(
    'host' => 'localhost',
    'username' => 'root',
    'password' =>  '',
    'db' => 'lrh'
    ),
    'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
    ),
    'session' => array(
    'session_name' => 'user',
    'token_name' => 'token'
    ),
    'email'=>array(
    'username'=>'',
    'password'=>'',
    'smtp'=>''
    )
  );