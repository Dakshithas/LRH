<?php
abstract class State{
    protected $context;
    public function setContext(User $context){
        $this->context=$context;
    }
    abstract public function handle():void;

    abstract public function log($type,$username,$pwd,$remember);
}
?>