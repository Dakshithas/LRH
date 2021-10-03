<?php
  class HolidayModel extends Model{
    protected $_db;
    private $_physiolist;

    public function __construct(){
      $this->_db = DB::getInstance();
      $this->_physiolist=$_SESSION['holiday']['physio_list']=HolidayModel::getphysio_list();
    }
    public function addPublicHoliday(){
        
    }
    public function addholiday($date){
      $field=[
        'physio_id'=>$_SESSION['holiday']['physio'],
        'date'=>$date
    ];
        $this->_db->insert('holiday',$field);
    }
    public function calendar($physio='')
    {
      // $_SESSION['appoinment']['defaultphysio']=$defaultphysio;
      $physio=isset($_SESSION['holiday']['physio'])?$_SESSION['holiday']['physio']:"";
      if (isset($_GET['month']) && isset($_GET['year'])) {
        $data = [
          'month' => $_GET['month'],
          'year' => $_GET['year'],
          'holidays' => $this->getholiday($physio),
          'publicholidays' => [],
          'physio_list' => $this->_physiolist,
          'physio' => $physio,
        ];
        // $li=$this->getavailabledays($data['month'], $data['physio']);
        // $data['bookslots']=$li;
        return $data;
      } else {
        $data = [
          'month' => date("m"),
          'year' => date("Y"),
          'holidays' => $this->getholiday($physio),
          'publicholidays' => [],
          'physio_list' => $this->_physiolist,
          'physio' => $physio,
        ];
        // $li=$this->getavailabledays($data['month'], $data['physio']);
        // $data['bookslots']=$li;
        return $data;
      }
  }
  public static function getphysio_list(){
    $data=DB::getInstance()->get('user',array('role'=>'physio'),array('username','id'));
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
  public function getholiday($physio){
    $data=$this->_db->get('holiday',array('physio_id'=>$physio));
    if(!$data){
      echo 'some error';
    }
    else{
      if($data->count()) {
        return array_column($data->results(),'date');
      }
      else{
        return array();
      }
    }
  }
}