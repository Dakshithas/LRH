<?php
  class PhysioModel extends Model{

    public function __construct($user=null){
      $this->_db = DB::getInstance();
    }
    public function getlist($table,$data,$field){
        $data=$this->_db->get($table, $data, $field);
        if($data->count()) {
          return $data->results();
        }
        else{
          return array();
        }
      }
      public function addrecord($data){
        if($this->_db->insert('patient_records', $data)) {
          return true;
        }
        else{
          return false;
        }
      }
      public function dailylist(){
        $today=date("Y-m-d");
        // echo $today;
        // $data['id']="patient_id";
        // $data=$this->_db->get(array('user','physio_patient'), $data);
        $sql="SELECT * FROM appoinment LEFT JOIN user ON appoinment.id=user.id WHERE date='{$today}' AND appoinment.physio_id=?";
        $value=$_SESSION['user_id'];
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

      public function list(){
        $sql="select DISTINCT user.id, user.username, user.email, user.bday, user.address, user.fname, user.mnumber, appoinment.time_slot, appoinment.date from user LEFT join appoinment on appoinment.id=user.id and appoinment.date=(select max(date) rnk from appoinment where id=id) where user.physio_id=?";
        $value=$_SESSION['user_id'];
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
      
  }