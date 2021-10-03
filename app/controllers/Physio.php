<?php
  class Physio extends User {
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }
      if($_SESSION['role']!='physio'){
        redirect('');
      }
      $this->userModel = $this->model('PhysioModel');
      $this->AppoinmentModel = $this->model('AppoinmentModel1');
      $this->user_id= 1;
      parent::__construct();
    }
    public function index(){
      $data['dailylist']=$this->dailylist();
      // print_r($data);
        $this->view('physio/index',$data);
    }
    public function dailylist(){
      return  $this->userModel->dailylist("appoinments",array('physio_id'=>$this->user_id),array('*'));
    }
    // public function list(){ 
    //   $data['dailylist']=$this->dailylist();
    //   // print_r($data);
    //     $this->view('physio/list',$data);
    // }
    public function absent(){

    }

    public function list(){
      $role="patient";
      $field=array('id','username','email','bday','fname','address','mnumber');
      
      $data=['role'=>$role];
      $data['list']=$this->userModel->list("user",$data,$field);
      $data['titles']=$field;
      $data['dailylist']=$this->dailylist();
      $this->view('physio/list',$data);
    }
    public function giveappoinment()
    {
      print_r($_POST);
      $physio=$_SESSION['appoinment']['physio']=$this->user_id;
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
        $_SESSION['appoinment']['patient']=$_POST['id'];
      }
    // if(isset($_GET['physio'])){
    //     $physio=$this->_physio=$_SESSION['appoinment']['physio']=trim($_GET['physio']);
    // }
      if (isset($_SESSION['appoinment']['patient'])){
         if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['timeslot'])) {
          $time_slot = $_POST['timeslot'];
          $date = $_POST['date'];
          $this->AppoinmentModel->saveappoinment($date, $time_slot);
          redirect('');
        }
        elseif (isset($_GET['date'])) {
          $date = $_GET['date'];
          $data = $this->AppoinmentModel->slots($date,$physio);
          $this->view('appoinment/slots', $data);
        }
        else{
        echo $physio;
        $data = $this->AppoinmentModel->calendar($physio);
        $this->view('appoinment/calendar', $data);
        }
      }
      else{
        // redirect('physio/index');
      }
    }
    public function addrecord()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = [
        'patient_id' => trim($_POST['patient_id']),
        'record' => trim($_POST['record']),
        'record_err' => ''
      ];
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'record' => array(
          'required' => true
        )
      ));
      if ($validation->passed()) {
        $data1 = [
          'patient_id' => $data['patient_id'],
          'record' =>$data['record'],
          'physio_id' => $_SESSION['user_id'],
        ];
        if($this->userModel->addrecord($data1)){
          echo '1';
        }
        else{
          echo '2';
        }
        
      }
      else{
        $data=array_merge($data,$validation->errors());
        $response = json_encode($data);
        echo $response;
      }
    }
  }
}
