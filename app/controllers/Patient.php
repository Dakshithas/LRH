<?php
class Patient extends User
{
  public function __construct()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }
    if($_SESSION['role']!='patient'){
      redirect('');
    }
    $this->userModel = $this->model('PatientModel');
    $this->AppoinmentModel = $this->model('AppoinmentModel1',[2,4]);
    parent::__construct();
  }
  public function index()
  {
    $this->view('patient/index');
  }
  public function sendmsg()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = [
        // 'contact_number' => '0770167004',
        // 'subject' => 'second meesge',
        // 'message' => 'this is the body of second messge. negombo mais stell college is',
        'contact_number' => trim($_POST['contact_number']),
        'subject' => trim($_POST['subject']),
        'message' => trim($_POST['message']),
        'contact_number_err' => '',
        'subject_err' => '',
        'message_err' => '',
      ];
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'contact_number' => array(
          'required' => true
        ),
        'subject' => array(
          'required' => true
        ),
        'message' => array(
          'required' => true
        ),
      ));
      if ($validation->passed()) {
        $data1 = [
          'patient' => $_SESSION['profile']['fname'],
          'contact_number' => $data['contact_number'],
          'subject' => $data['subject'],
          'message' => $data['message'],
        ];
        if($this->userModel->sendmsg($data1)){
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
    public function chgappoinment1()
    {
      if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $data = $this->AppoinmentModel->slots($date);
        $this->view('appoinment/slots', $data);
      } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $time_slot = $_POST['timeslot'];
        $date = $_POST['date'];
        $this->AppoinmentModel->saveappoinment($date, $time_slot);
        redirect('');
      } else {
        $data = $this->AppoinmentModel->calendar();
        $this->view('appoinment/calendar', $data);
      }
    }
    public function chgappoinment()
    {
      $_SESSION['appoinment']['patient']=$_SESSION['user_id'];
      $_SESSION['appoinment']['physio']=2;                                                      //get physio method
      if (isset($_SESSION['appoinment']['patient'])){
         if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['timeslot'])) {
          $time_slot = $_POST['timeslot'];
          $date = $_POST['date'];
          $this->AppoinmentModel->saveappoinment($date, $time_slot);
          redirect('');
        }
        elseif (isset($_GET['date']) && isset($_SESSION['appoinment']['physio'])) {
          $date = $_GET['date'];
          $physio=$_SESSION['appoinment']['physio'];
          $data = $this->AppoinmentModel->slots($date,$physio);
          $this->view('appoinment/slots', $data);
        }
        else{
        $data = $this->AppoinmentModel->calendar();
        $this->view('appoinment/calendar', $data);
        }
      }
      else{
        // redirect('physio/index');
      }
    }
    
}
