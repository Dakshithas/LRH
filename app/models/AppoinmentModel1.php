<?php
  class AppoinmentModel1 extends Model{
    protected $_db;
    private $_patient,
            $_physio,
            $_defaultphysio,
            $_physiolist;
    public function __construct(){
      $this->_db = DB::getInstance();
      // $this->_patient= $_SESSION['appoinment']['patient'];
      // $this->_physio=$_SESSION['appoinment']['physio'];
      // $this->_defaultphysio=$_SESSION['appoinment']['defaultphysio']=$_SESSION['appoinment']['physio'];
      $this->_physiolist=$_SESSION['appoinment']['physio_list']=AppoinmentModel1::getphysio_list();
    }
    public function calendar($physio='')
    {
      $defaultphysio=($physio!="")?$physio:(isset($_SESSION['appoinment']['defaultphysio'])?$_SESSION['appoinment']['defaultphysio']:2);
      $_SESSION['appoinment']['defaultphysio']=$defaultphysio;
      $physio=isset($_SESSION['appoinment']['physio'])?$_SESSION['appoinment']['physio']:$defaultphysio;
      // if($_SESSION['appoinment']['physio']){
      //   $physio=$_SESSION['appoinment']['physio'];
      // }
      // elseif($physio==""){
      //   $patient= $_SESSION['appoinment']['patient'];
      //   $defaultphysio=2;
      // }
      if (isset($_GET['month']) && isset($_GET['year'])) {
        $data = [
          'month' => $_GET['month'],
          'year' => $_GET['year'],
          'no_of_slots' => 5,
          'physio_list' => $this->_physiolist,
          'physio' => $physio,
          'defaultphysio' => $defaultphysio,
        ];
        $li=$this->getavailabledays($data['month'], $data['physio']);
        $data['bookslots']=$li;
        return $data;
      } else {
        $data = [
          'month' => date("m"),
          'year' => date("Y"),
          'no_of_slots' => 5,
          'physio_list' => $this->_physiolist,
          'physio' => $this->_physio,
          'defaultphysio' => $this->_defaultphysio
        ];
        $li=$this->getavailabledays($data['month'], $data['physio']);
        $data['bookslots']=$li;
        return $data;
      }
    }













    // public function __construct(){
    //     if(isset($_POST['id'])){
    //         $this->_db = DB::getInstance();
    //         $this->_patient_id= $_SESSION['appoinment']['patient_id']=trim($_POST['id']);
    //         // $this->_physiolist=$_SESSION['appoinment']['physio_list']=$this->appoinmentModel->getphysio_list();
    //         $this->_physio=$_SESSION['appoinment']['physio']=4;
    //         $this->_defaultphysio=$_SESSION['appoinment']['defaultphysio']=$_SESSION['appoinment']['physio'];
    //         // $this->appoinmentModel->getphysio($this->_patient_id);
    //     }elseif(isset($_SESSION['appoinment']['patient_id']) && isset($_SESSION['appoinment']['physio']) && isset($_SESSION['appoinment']['physio_list'])){
    //         $this->_db = DB::getInstance();
    //         $this->_patient_id=$_SESSION['appoinment']['patient_id'];
    //         $this->_physiolist=$_SESSION['appoinment']['physio_list'];
    //         $this->_physio=$_SESSION['appoinment']['physio'];
    //         $this->_defaultphysio=$_SESSION['appoinment']['defaultphysio'];
    //     }
    //     else{
    //         redirect($_SESSION['role']."/index");
    //     }
        
    //   }
    // public function calendar1(){
    //     if(isset($_GET['physio'])){
    //         $this->_physio=$_SESSION['appoinment']['physio']=trim($_GET['physio']);
    //     }
    //     if(isset($_GET['month']) && isset($_GET['year'])){
    //         $data=[
    //             'month'=>$_GET['month'],
    //             'year'=>$_GET['year'],
    //             'no_of_slots'=>5,
    //             'physio_list'=>$this->_physiolist,
    //             'physio'=>$this->_physio,
    //             'defaultphysio'=>$this->_defaultphysio
    //         ];
    //         $li=$this->getavailabledays($data['month'],$data['physio']);
    //         return $li;
    //     }
    //     elseif(isset($_GET['date'])){
    //         $date=$_GET['date'];
    //         $this->slots($date);
    //     }
    //     else{
    //         $data=[
    //             'month'=>date("m"),
    //             'year'=>date("Y"),
    //             'no_of_slots'=>5,
    //             'physio_list'=>$this->_physiolist,
    //             'physio'=>$this->_physio,
    //             'defaultphysio'=>$this->_defaultphysio
    //         ];
    //         $li=$this->getavailabledays(date('m'),$data['physio']);
    //         return $li;
    //     }

    // }
    public function slots($date,$physio){
        $li=$this->getavailableslots($date,$physio);
        $booking=(array_column($li, 'time_slot'));
        $data=[
            'duration' => 20,
            'cleanup' => 0,
            'start' => "09:00",
            'end' => "15:00",
            'date'=>$date,
            'bookings'=>$booking
        ];
        return $data;
        
    }
    public function saveappoinment($date,$time_slot){
      echo 'ssssssssssssssssss';
      $field=[
        'physio_id'=>$_SESSION['appoinment']['physio'],
        'id'=>$_SESSION['appoinment']['patient'],
        'time_slot'=>$time_slot,
        'date'=>$date
    ];
        $where=['physio_id','=',$this->_physio];
        $this->_db->insert('appoinment',$field);
    }
    // public function getavailableslots($date){
    //   $data = $this->_db->get('appoinments', array('date'=>$date),array('time_slot'));
    //   if($data->count()) {
    //     return $data->results();
    //   }
    //   else{
    //     return array();
    //   }
    // }
    public function getavailabledays($month,$physio){
      $data = $this->_db->get('appoinment', array('MONTH(date)'=>$month,'physio_id'=>$physio));
      if($data->count()) {
        return array_count_values(array_column($data->results(),'date'));
      }
      else{
        return array();
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
    public function getavailableslots($date,$physio){
      $data = $this->_db->get('appoinment', array('date'=>$date,'physio_id'=>$physio),array('time_slot'));
      if($data->count()) {
        return $data->results();
      }
      else{
        return array();
      }
    }

  }