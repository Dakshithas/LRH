<?php
  class User{
    private $db;
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user=null){
      // $this->db = new Database;
      $this->_db = DB::getInstance();
      // $this->_sessionName = Core::get('session/session_name');
      // $this->_cookieName = Core::get('remember/cookie_name');

      if (!$user) {
        if (Session::exists($this->_sessionName)) {
          $user = Session::get($this->_sessionName);
          if ($this->find($user)) {
            $this->_isLoggedIn = true;
          } else {
            // process logout
          }
        }
      } 
      else {
        $this->find($user);
      }
    }

    public function find($user = null)
  {
    if($user) {
      $field = (strpos($user,'@')) ? 'email' : 'username';                    //****USE NIC HERE */
      $data = $this->_db->get('user', array($field=> $user));
      if($data->count()) {
        $this->_data = $data->first();
        return true;
      }
    }
    return false;
  }
  public function login1($email, $password){
    if(isset($_SESSION['role'])){
      redirect(HOME);
    }
    if(password_verify($password, $this->data()->password)){
      return $this->data();
    }
    else{
      return false;
    }
  }
  public function data()
  {
    return $this->_data;
  }
  public function register1($data){
    if($this->_db->insert('user', array_slice($data,0,3))) {
      return true;
    }
    else{
      return false;
    }
  }
}