<?php

class Validate {

  private $_passed = false,
          $_errors = array(),
          $_db     = null;

  public function __construct()
  {
    $this->_db = DB::getInstance();
  }

  public function check($source, $items = array())
  {
    foreach ($items as $item => $rules) {
      $_item=array();
      foreach($rules as $rule => $rule_value) {
        //echo "{$item} {$rule} must be {$rule_value}<br>";
        $_error =null;
        $value =  trim($source[$item]);
        if ($rule === 'required' && empty($value)) {
          $_error="{$item} is required";
        } else if(!empty($value)){
          switch ($rule) {

            case 'min':
              if (strlen($value) < $rule_value) {
                $_error="{$item} must be a minimum of {$rule_value} characters.";
              }
            break;

            case 'max':
            if (strlen($value) > $rule_value) {
              $_error="{$item} must be a maximum of {$rule_value} characters.";
            }
            break;

            case 'matches':
              if ($value != $source[$rule_value]) {
                $_error="{$rule_value} must match {$item}";
              }
            break;

            case 'unique':
              $check = $this->_db->get($rule_value, array($item, '=', $value));
              if ($check->count()) {
                $_error="{$item} already exists.";
              }
            break;

            case 'maxdate':
              if ($value > trim($source[$rule_value])) {
                $_error=ucfirst($item)." must be at earliest ".ucfirst($rule_value);
              }
            break;

            case 'mindate':
              if ($value < trim($source[$rule_value])) {
                $_error=ucfirst($item)." must be at latest ".ucfirst($rule_value);
              }
            break;

            default:
              # code...
              break;
          }
        }
        if(!empty($_error)){
          $_item[]=str_replace("_"," ",$_error);
        }
      
      }
      if(!empty($_item)){
        $this->_errors["{$item}_err"]=$_item;
      }
    }
    if (empty($this->_errors)) {
      $this->_passed = true;
    }
    return $this;
  }

  private function addError($error)
  {
    $this->_errors[] = $error;
  }

  public function errors()
  {
    return $this->_errors;
  }

  public function passed()
  {
    return $this->_passed;
  }

} // fim classe
