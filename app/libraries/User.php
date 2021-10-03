<?php
  class User extends Controller{
    protected $userModal;
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }
      // $this->adminModel = $this->model('AdminModel');
      $user=$this->userModel->getprofile($_SESSION['user_id']);
        $profile =[
          'role'=>$user->role,
          'fname'=>$user->fname,
          'lname'=> $user->lname,
          'email' =>$user->email,
          'username' =>$user->username,
          'nic'=> $user->nic,
          'bday'=> $user->bday,
          'mnumber'=> $user->mnumber,
          'lnumber'=> $user->lnumber,
          'address'=> $user->address,
          'pic'=>$user->pic
        ];
        // print_r($profile);
        $_SESSION['profile']=$profile;
    }
    public function updateinfo(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data =[
          'fname'=> trim($_POST['first_name']),
          'lname'=> trim($_POST['last_name']),
          'email' => trim($_POST['email']),
          'bday'=> trim($_POST['birth_day']),
          'mnumber'=> trim($_POST['mobile_number']),
          'lnumber'=> trim($_POST['land_number']),
          'address'=> trim($_POST['address']),
          'first_name_err'=>'',
          'last_name_err'=>'',
          'email_err'=>'',
          'username_err' => '',
          'birth_day_err'=>'',
          'mobile_number_err'=>'',
          'land_number_err'=>''
        ];
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
          'first_name' => array(
            'required' => true
          ),
          'last_name' => array(
            'required' => true
          ),
          'email' => array(
            'required' => true
          ),
          'birth_day' => array(
            'required' => true
          ),
          'mobile_number' => array(
            'required' => true
          ),
          // 'land_number' => array(
          //   'required' => true
          // ),
          'address' => array(
            'required' => true
          )
        ));
        if ($validation->passed()) {
          $this->userModel->updateprofile($_SESSION['user_id'],array_slice($data,0,7));
          echo '1';

        } else {
        //   // Load view with errors
          $data=array_merge($data,$validation->errors());
          $response = json_encode($data);
          echo $response;
        }

      } 
    }

    public function changepwd(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data =[
          // 'newpwd'=> 'dakshitha',
          // 'confirmpwd' => 'dakshitha',
          // 'currentpwd'=> 'suriya',
          'newpwd'=> trim($_POST['new_password']),
          'confirmpwd' => trim($_POST['retype_new_password']),
          'currentpwd'=> trim($_POST['current_password']),
          'new_password_err'=>'',
          'retype_new_password_err'=>'',
          'current_password_err'=>''
        ];
        if($this->userModel->checkpassword($_SESSION['user_id'],$data['currentpwd'])){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
          'new_password' => array(
            'required' => true,
            'min' => 6
          ),
          'retype_new_password' => array(
            'required' => true,
            'matches' => 'new_password'
          ),
        ));
        if ($validation->passed()) {
          $newpwd=password_hash($data['newpwd'], PASSWORD_DEFAULT);
          $this->userModel->updateprofile($_SESSION['user_id'],array('password'=>$newpwd));
          echo '1';

        } else {
         // Load view with errors
          $data=array_merge($data,$validation->errors());
          $response = json_encode($data);
          echo $response;
        }

      }
      else{
        $data['current_password_err']="Entered Password is incorrect";
        $response = json_encode($data);
        echo $response;
      } 
    }
  }
}