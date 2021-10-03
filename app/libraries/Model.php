<?php 
Class Model{
  protected $_db;

  public function update($id) {
    $this->_db->update('message', array('status' => '1'), array(array('msg_id', '=', $id)));
  }

  public function getprofile($id){
    $data = $this->_db->get('user', array('id' => $id));
    if ($data->count()) {
      return $data->first();
    } else {
      return array();
    }
  }

  public function data(){
    return $this->_data;
  }
  public function updateprofile($id,$field){
    $this->_db->update('user', $field, array(array('id', '=', $id)));
  }
  public function checkpassword($id,$checkpwd){
    $pwd=$this->_db->get('user', array('id' => $id),array('password'));
    $pwd=$pwd->first()->password;
    if(password_verify($checkpwd, $pwd)){
      return true;
    }
    else{
      return false;
    }
  }

}