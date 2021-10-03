<?php
  class PatientModel extends Model{

    public function __construct($user=null){
      $this->_db = DB::getInstance();
    }
    public function sendmsg($data){
      if($this->_db->insert('message', $data)) {
        return true;
      }
      else{
        return false;
      }
    }
  }