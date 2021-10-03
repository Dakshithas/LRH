<?php
  class Admin extends User{
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }
      if($_SESSION['role']!='admin'){
        redirect('');
      }
      // $this->adminModel = $this->model('AdminModel');
      $this->userModel = $this->model('AdminModel');
      $this->holidayModel = $this->model('HolidayModel');
      parent::__construct();
      // if(!isset($_SESSION['profile'])){
        // $user=$this->userModel->getprofile($_SESSION['user_id']);
        // $profile =[
        //   'role'=>$user->role,
        //   'fname'=>$user->fname,
        //   'lname'=> $user->lname,
        //   'email' =>$user->email,
        //   'username' =>$user->username,
        //   'nic'=> $user->nic,
        //   'bday'=> $user->bday,
        //   'mnumber'=> $user->mnumber,
        //   'lnumber'=> $user->lnumber,
        //   'address'=> $user->address
        // ];
        // // print_r($profile);
        // $_SESSION['profile']=$profile;
      // }
      
    }

    // public function index(){
    //   // Get posts
    //   // $posts = $this->postModel->getPosts();

    //   $data = [
    //     // 'posts' => $posts
    //   ];

    //   $this->view('admin/index', $data);
    // }
    public function index(){
      // if($_SERVER['REQUEST_METHOD'] == 'POST'){
      //   $delete_id=$_POST['delete_id'];
      //   $role=$_GET['type'];
      //   if($role=='physio'){
      //     $this->deletephysio($delete_id);
      //   }
      //   elseif($role=='recep'){
      //     $this->deleterecep($delete_id);
      //   }
      //   elseif($role=='patient'){
      //     $this->deletepatient($delete_id);
      //   }
      // }
      // if(isset($_GET['type'])){
      //   if($_GET['type']=='physio'){
      //     $role='physio';
      //     $field=array('id','username','email');
      //   }
      //   elseif($_GET['type']=='recep'){
      //     $role="recep";
      //     $field=array('id','username','email');
      //   }
      //   else{
      //     $role="patient";
      //     $field=array('id','username','email');
      //   }
      // }
      // else{
      //   $role="patient";
      //   $field=array('id','username','email');
      // }
      // $data=['role'=>$role];
      // $data['list']=$this->userModel->getlist($data,$field);
      // $data['titles']=$field;
      $data=[];
      $this->view('admin/index',$data);
    }

    public function register(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
  
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data =[
          'role'=> trim($_POST['role']),
          'fname'=> trim($_POST['fname']),
          'lname'=> trim($_POST['lname']),
          'email' => trim($_POST['email']),
          'username' => trim($_POST['username']),
          'nic'=> trim($_POST['nic']),
          'bday'=> trim($_POST['bday']),
          'mnumber'=> trim($_POST['mnumber']),
          'lnumber'=> trim($_POST['lnumber']),
          'address'=> trim($_POST['address']),
          'password'=>'',
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
        

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
          
         
          'username' => array(
            'required' => true,
            'min' => 2,
            'max' => 50,
            'unique'
          ),
          'email' => array(
            'required' => true
          ),
          'role' => array(
            'required' => true
          ),
          'bday'=> array(
            'required' => true
          )
        ));
        if ($validation->passed()) {
          //paswword = first name + birthday date dakshitha23
          // $password=trim($_POST['fname']).date_format($_POST['bday'],"d");
          $password=trim($_POST['fname']).date('d',strtotime($_POST['bday']));
          // echo $password;
          //hash password
          $data['password']=password_hash($password, PASSWORD_DEFAULT);
          // Register User
          if($this->userModel->register1($data)){
            flash('register_success', 'You are registered and can log in');
            redirect('admin/index');
          } else {
            die('Something went wrong');
          }

        } else {
          // Load view with errors
          // print_r($validation->errors());
          $this->view('admin/register', array_merge($data,$validation->errors()));
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
          'password'=>'',
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
        $this->view('admin/register', $data);
      }
    }
    public function msglist()
  {
    // print_r($_POST);
    $type=((isset($_GET['type']) && $_GET['type']=='seen') ||(isset($_POST['type']) && $_POST['type']=='seen') )?1:0;
    // echo $type;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $date=date("Y-m-d");
      $data =[
        'to'=> empty($_POST['to'])?date("Y-m-d", strtotime($date . " - 0 day")):trim($_POST['to']),
        'from' => empty($_POST['from'])?date("Y-m-d", strtotime($date . " - 365 day")):trim($_POST['from']),
        'from_err' => '',
        'to_err'=>'',
        'list'=>array(),
        'today'=>date("Y-m-d"),
        'titles'=>array('msg_id','patient_id','msg','date'),
        'type'=>trim($_POST['type'])
      ];
      // print_r($data);
      $validate = new Validate();
      $validation = $validate->check($data, array(
        
        'from' => array(
          'maxdate' => 'to'
        ),
        'to' => array(
          'maxdate' => 'today',
          'mindate' => 'from'
        )
      ));
      if ($validation->passed()) {
        $li=$this->userModel->getmsglist($data['to'],$data['from'],$type);
        if(is_array($li)){
          $data['list']=$li;
          $this->view('admin/messages', $data);
        }
        else{
          die('Something went wrong');
        }
      }
      else{
        $this->view('admin/messages', array_merge($data,$validation->errors()));
      }
    }
    else{
      $date=date("Y-m-d");
      $data =[
        'to'=> date("Y-m-d", strtotime($date . " - 0 day")),
        'from' =>date("Y-m-d", strtotime($date . " - 365 day")),
        'from_err' => '',
        'to_err'=>'',
        'list'=>array(),
        'titles'=>array('msg_id','patient_id','msg','date'),
        'type'=>(isset($_GET['type']))?trim($_GET['type']):'unseen'
      ];
      $data['list']=$this->userModel->getmsglist($data['to'],$data['from'],$type);
      $this->view('admin/messages', $data);
    }  
  }

  public function viewmsg(){
    $id=$_POST['msg_id'];
    $this->userModel->update($id);
  }

  public function search($table,$field1,$operator1,$val1,$field2,$operator2,$val2){
    if(!$val2 or !$field2){
      $data1 = $this->_db->get($table, array('`'.$field1.'`', $operator1, $val1));
    }
    else{
    $data1 = $this->_db->get($table, array('`'.$field1.'`', $operator1, $val1, '`'.$field2.'`', $operator2, $val2));}
    if($data1->count()) {
      return $data1->results();
  }
  }
  // public function patients(){
  //   if($_SERVER['REQUEST_METHOD'] == 'POST'){
  //     $data=[
  //       'physio'=> trim($_POST['physio']),
  //       'username'=>trim($_POST['username']),
  //       'appoinment'=>trim($_POST['appoinment']),
  //     ];
  //     $li=$this->adminModel->getlist('patient',$data);
  //     $this->view('admin/lists',array_filter($data));
  //   }
  //   else{
  //     $data['role']='admin';
  //     $data=$this->adminModel->getlist($data);
  //     print_r($data);
  //     $this->view('admin/lists',$data);
  //   }
  // }
  public function list()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $delete_id = $_POST['delete_id'];
      $role = (isset($_GET['type'])) ? $_GET['type'] : "patient";
      if ($role == 'physio') {
        $this->deletephysio($delete_id);
      } elseif ($role == 'recep') {
        $this->deleterecep($delete_id);
      } elseif ($role == 'patient') {
        $this->deletepatient($delete_id);
      }
    }
    if (isset($_GET['type'])) {     //localhost/prohetsn/admin/list?type=patient
      if ($_GET['type'] == 'physio') {
        $role = 'physio';
        $field = array('id', 'username', 'email','address','mnumber','bday');
        $data = ['role' => $role];
        $data['list'] = $this->userModel->getlist($data, $field);
        $data['titles'] = $field;
        $this->view('admin/lists', $data);
      } elseif ($_GET['type'] == 'recep') {
        $role = "recep";
        $field = array('id', 'username', 'email','address','mnumber','bday');
        $data = ['role' => $role];
        $data['list'] = $this->userModel->getlist($data, $field);
        $data['titles'] = $field;
        $this->view('admin/lists', $data);
      } else {
        $role = "patient";
        $field = array('id', 'username', 'email');
      }
    } else {
      $role = "patient";
      $field = array('id', 'username', 'email');
    }
    $field = array('id', 'username', 'email','address','mnumber','bday','physioname');
    $data = ['role' => $role];
    // $data['list']=$this->userModel->getlist($data,$field);
    $data['titles'] = $field;
    // $this->view('admin/lists',$data);
    $data['list'] = $this->userModel->getpatientlist();
    $this->view('admin/lists', $data);
  }
  public function deletephysio($id){
    $this->userModel->deleteuser($id);
  }
  public function deleterecep($id){
    $this->userModel->deleteuser($id);
  }
  public function deletepatient($id){
    $this->userModel->deleteuser($id);
  }
  public function deactivate(){
    $this->userModel->activatedphysio();
  }
  public function addholiday()
  {
    if (isset($_GET['physio'])) {
      $physio = $this->_physio = $_SESSION['holiday']['physio'] = trim($_GET['physio']);
      $data = $this->holidayModel->calendar();
      $this->view('shared/calendar', $data);
    }
    if (isset($_SESSION['holiday']['physio'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['date'])) {
        $date = $_POST['date'];
        $this->holidayModel->addholiday($date);
        // redirect('');
      }
      $data = $this->holidayModel->calendar();
      $this->view('shared/calendar', $data);
    } else {
      $data = $this->holidayModel->calendar();
      $this->view('shared/calendar', $data);
    }
    
  }
}

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
//   $_SESSION['appoinment']['patient']=$_POST['id'];
// }
// if(isset($_GET['physio'])){
//   $physio=$this->_physio=$_SESSION['appoinment']['physio']=trim($_GET['physio']);
// }
// if (isset($_SESSION['appoinment']['patient'])){
//    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['timeslot'])) {
//     $time_slot = $_POST['timeslot'];
//     $date = $_POST['date'];
//     $this->AppoinmentModel->saveappoinment($date, $time_slot);
//     redirect('');
//   }
//   elseif (isset($_GET['date']) && isset($_SESSION['appoinment']['physio'])) {
//     $date = $_GET['date'];
//     $physio=$_SESSION['appoinment']['physio'];
//     $data = $this->AppoinmentModel->slots($date,$physio);
//     $this->view('appoinment/slots', $data);
//   }
//   else{
//   $data = $this->AppoinmentModel->calendar();
//   $this->view('appoinment/calendar', $data);
//   }
// }
// else{
//   // redirect('physio/index');
// }