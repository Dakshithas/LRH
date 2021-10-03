<?php
class ActivatedState extends State{
    protected $_db;
    public function __construct(){
        $this->_db = DB::getInstance();}
        
    public function handle():void{
        // $this->context->transitionTo(new DeactivatedState());
    }

    public function log($type,$username,$pwd,$remember){ 
        // $login = $this->context->login($type, $username, $pwd, $remember);
      
        //     if ($login) {
        //       Redirect::to('index.php');
        //     } else {
        //       echo "<p class='label label-danger'>Sorry, logging in failed.</p><br><br>";
        //     }
    }
    public function gh(){
        echo 'sssssssssssssssssssssssssssssssssssssssssssssssssssssss';
    }
}

?>