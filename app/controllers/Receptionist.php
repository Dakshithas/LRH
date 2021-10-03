<?php
  class Receptionist extends User {
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }
      if($_SESSION['role']!='receptionist'){
        redirect('');
      }
      $this->userModel = $this->model('RecepModel');
      $this->AppoinmentModel = $this->model('AppoinmentModel1');
      parent::__construct();
    }

    // public function index(){
    //   // Get posts
    //   // $posts = $this->postModel->getPosts();

    //   $data = [
    //     // 'posts' => $posts
    //   ];

    //   $this->view('receptionist/index', $data);
    // }

    public function index(){
      if(isset($_GET['type'])){
        if($_GET['type']=='physio'){
          $role='physio';
          $field=array('id','username','email');
        }
        elseif($_GET['type']=='recep'){
          $role="recep";
          $field=array('id','username','email');
        }
        else{
          $role="patient";
          $field=array('id','username','email');
        }
      }
      else{
        $role="patient";
        $field=array('id','username','email');
      }
      $data=['role'=>$role];
      $data['list']=$this->userModel->getlist($data,$field);
      $data['titles']=$field;
      $this->view('receptionist/index',$data);
    }

    public function register(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data =[
          'role'=> 'patient',
          'fname'=> trim($_POST['fname']),
          'lname'=> trim($_POST['lname']),
          'email' => trim($_POST['email']),
          'username' => trim($_POST['username']),
          'nic'=> trim($_POST['nic']),
          'bday'=> trim($_POST['bday']),
          'mnumber'=> trim($_POST['mnumber']),
          'lnumber'=> trim($_POST['lnumber']),
          'address'=> trim($_POST['address']),
          'fname_err'=>array(),
          'lname_err'=>array(),
          'email_err'=>array(),
          'username_err' => array(),
          'nic_err' => array(),
          'bday_err'=>array(),
          'mnumber_err'=>array(),
          'lnumber_err'=>array()
        ];
        

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
          
          // 'password' => array(
          //   'required' => true,
          //   'min' => 6
          // ),
          // 'confirm_password' => array(
          //   'required' => true,
          //   'matches' => 'password'
          // ),
          'username' => array(
            'required' => true,
            'min' => 2,
            'max' => 50
          ),
          'email' => array(
            'required' => true
          ),
        ));
        if ($validation->passed()) {
          //paswword = first name + birthday date dakshitha23
          $password=trim($_POST['fname']).date_format(trim($_POST['bday']),"d");
          //hash password
          $data['password']=password_hash($password, PASSWORD_DEFAULT);
          // Register User
          if($this->userModel->register1($data)){
            flash('register_success', 'You are registered and can log in');
            redirect('receptionist/index');
          } else {
            die('Something went wrong');
          }

        } else {
          // Load view with errors
          // print_r(array_merge($data,$validation->errors()));
          $this->view('receptionist/register', array_merge($data,$validation->errors()));
        }

      } else {
        // Init data
         $data =[
          'role'=> '',
          'fname'=>'',
          'lname'=> '',
          'email' =>'' ,
          'username' =>'',
          'nic'=> '',
          'bday'=> '',
          'mnumber'=> '',
          'lnumber'=> '',
          'address'=> '',
          'role_err'=>'',
          'fname_err'=>'',
          'lname_err'=>'',
          'email_err'=>'',
          'username_err' => '',
          'nic_err' => '',
          'bday_err'=>'',
          'mnumber_err'=>'',
          'lnumber_err'=>''
        ];

        // Load view
        $this->view('receptionist/register', $data);
      }
    }
    public function list(){
      if(isset($_GET['type'])){
        if($_GET['type']=='physio'){
          $role='physio';
          $field=array('id','username','email');
        }
        elseif($_GET['type']=='recep'){
          $role="recep";
          $field=array('id','username','email');
        }
        else{
          $role="patient";
          $field=array('id','username','email');
        }
      }
      else{
        $role="patient";
        $field=array('id','username','email');
      }
      $data=['role'=>$role];
      $data['list']=$this->userModel->getlist($data,$field);
      $data['titles']=$field;
      $this->view('receptionist/list',$data);
    }
    public function giveappoinment()
    {
      // print_r($_POST);
      // $physio=$_SESSION['appoinment']['physio']=$this->user_id;
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
        $_SESSION['appoinment']['patient']=$_POST['id'];
      }
    if(isset($_GET['physio'])){
        $physio=$this->_physio=$_SESSION['appoinment']['physio']=trim($_GET['physio']);
    }
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