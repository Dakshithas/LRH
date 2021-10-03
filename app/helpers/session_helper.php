<?php
  session_start();

  // Flash message helper
  // EXAMPLE - flash('register_success', 'You are now registered');
  // DISPLAY IN VIEW - echo flash('register_success');
  function flash($name = '', $message = '', $class = 'alert alert-success'){
    if(!empty($name)){
      if(!empty($message) && empty($_SESSION[$name])){
        if(!empty($_SESSION[$name])){
          unset($_SESSION[$name]);
        }

        if(!empty($_SESSION[$name. '_class'])){
          unset($_SESSION[$name. '_class']);
        }

        $_SESSION[$name] = $message;
        $_SESSION[$name. '_class'] = $class;
      } elseif(empty($message) && !empty($_SESSION[$name])){
        $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
        echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name. '_class']);
      }
    }
  }

  function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
      return true;
    } else {
      return false;
    }
  }
  function isPatient(){
    if(isset($_SESSION['role']) && $_SESSION['role']=='patient'){
      return true;
    }
    else{
      return false;
    }
  }
  function isReceptionist(){
    if(isset($_SESSION['role']) && $_SESSION['role']=='recep'){
      return true;
    }
    else{
      return false;
    }
  }
  function isAdmin(){
    if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){
      return true;
    }
    else{
      return false;
    }
  }
  function isPhysio(){
    if(isset($_SESSION['role']) && $_SESSION['role']=='physio'){
      return true;
    }
    else{
      return false;
    }
  }
