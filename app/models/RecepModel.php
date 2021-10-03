<?php
// require_once 'User.php';
  class RecepModel extends Model{
    private $db;
    private $_data,
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
      $data = $this->_db->get('user', array($field, '=', $user));
      if($data->count()) {
        $this->_data = $data->first();
        return true;
      }
    }
    return false;
  }
  public function register1($data){
    if($this->_db->insert('user', array_filter($data))) {
      return true;
    }
    else{
      return false;
    }
  }
  public function getmsglist($to,$from){
    $data = $this->_db->get('message', array(array('date','>',$from),array('date','<',$to)));
    if($data->count()) {
      return $data->results();
    }
    else{
      return array();
    }
  }
  public function getlist($data,$field){
    $data=$this->_db->get('user', $data, $field);
    if($data->count()) {
      return $data->results();
    }
    else{
      return array();
    }
  }
}