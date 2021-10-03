<?php
// require_once 'User.php';
  class AdminModel extends Model{
    private $db;
    protected $_data,
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
    if($this->_db->insert('user', array_slice($data,0,11))) {
      return true;
    }
    else{
      return false;
    }
  }
  public function getmsglist($to,$from,$type){
    $data = $this->_db->get('message', array(array('date','>',$from),array('date','<',$to),array('status','=',$type)));
    if($data->count()) {
      return $data->results();
    }
    else{
      return array();
    }
  }
  public function getlist($data,$field){
    // $data['id']="patient_id";
    // $data=$this->_db->get(array('user','physio_patient'), $data);
    $data=$this->_db->get('user', $data, $field);
    if($data->count()) {
      return $data->results();
    }
    else{
      return array();
    }
  }
  public function getpatientlist(){
    // $data['id']="patient_id";
    // $data=$this->_db->get(array('user','physio_patient'), $data);
    $sql='SELECT c1.id, c1.username, c1.email, c1.bday, c1.address, c1.mnumber, c2.username as physioname FROM user c1 INNER JOIN user c2 ON c1.physio_id = c2.id';
    $value='';
    // $data=$this->_db->query($sql, array($value))->error();
    if (!$this->_db->query($sql, array($value))->error()) {
      $data=$this->_db;
    }
    // $data=$this->_db->get('user', $data, $field);
    if($data->count()) {
      return $data->results();
    }
    else{
      return array();
    }
  }
  public function deleteuser($id){
    $this->_db->delete('user', array('`id`', '=', $id));
  }
  public function activatedphysio(){
    require_once 'State\ActivatedState.php';
    $st=new ActivatedState();
    $st->gh();
  }
}