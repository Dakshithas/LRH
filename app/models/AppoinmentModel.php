<?php
  class AppoinmentModel{
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user=null){
      $this->_db = DB::getInstance();
    }
    public function saveappoinment($field,$where){
        $this->_db->insert('appoinments',$field);
    }
    public function getavailableslots($date){
      $data = $this->_db->get('appoinments', array('date'=>$date),array('time_slot'));
      if($data->count()) {
        return $data->results();
      }
      else{
        return array();
      }
    }
    public function getavailabledays($month,$physio){
      $data = $this->_db->get('appoinments', array('MONTH(date)'=>$month,'physio_id'=>$physio));
      if($data->count()) {
        return array_count_values(array_column($data->results(),'date'));
      }
      else{
        return array();
      }
    }
    public function getphysio_list(){
      $data=$this->_db->get('user',array('role'=>'physio'),array('username','id'));
      if(!$data){
        echo 'some error';
      }
      else{
        if($data->count()) {
          return $data->results();
        }
        else{
          return array();
        }
      }
    }
  }