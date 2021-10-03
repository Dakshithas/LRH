<?php
class DeactivatedState extends State{
    public function handle():void{
        // $this->context->transitionTo(new ActivatedState());
    }

    public function log($type,$username,$pwd,$remember){
        echo"This account has been deactivated. Contact hospital reception for assistance";
    }
}
?>