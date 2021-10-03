<?php
  class Users extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
    }
    public function index(){
      $data = [
        // 'posts' => $posts
      ];

      $this->view('users/index', $data);
    }

    public function login(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        $data =[
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',      
        ];

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
                                'email' => array('required' => true),
                                'password' => array('required' => true)));
        if($validation->passed()) {

        if($this->userModel->find($data['email'])){
          // Validated
          // Check and set logged in user
          $loggedInUser = $this->userModel->login1($data['email'], $data['password']);

          if($loggedInUser){
            $this->createUserSession($loggedInUser);
            redirect(($loggedInUser->role).'/index');
            // Create Session
            
            // redirect('post');
            // $this->view('users/index');
          } else {
            $data['password_err'] = array('Password incorrect');

            $this->view('users/login', $data);
        }
        }
        else{
          // User not found
          $data['email_err'] = array('No user found');
          $this->view('users/login', $data);

        }

        } else {
          // Load view with errors
          $this->view('users/login', array_merge($data,$validation->errors()));
        }


      } else {
        // Init data
        $data =[    
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',        
        ];

        // Load view
        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user){
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
        'address'=> $user->address
      ];
    
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->username;
      $_SESSION['role'] = $user->role;
      // redirect('posts');
    }

    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('users/login');
    }
  }