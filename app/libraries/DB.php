<?php
class DB {
  private static $_instance = null;
  private $_pdo,
          $_query,
          $_error = false,
          $_results,
          $_count = 0;
  private function __construct()
  {
    try {
      $this->_pdo = new PDO('mysql:host='. Core::get('mysql/host') .';dbname='. Core::get('mysql/db'), Core::get('mysql/username'), Core::get('mysql/password'));
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }
  public static function getInstance()
  { 
    if(!isset(self::$_instance)) {
      self::$_instance = new DB();
    }
    return self::$_instance;
  }
  public function query($sql, $params = array())
  {
    // echo "<br><br><br><br><br><br>";
    // echo $sql.'<br>';
    // print_r($params);
    // echo '<br>';
    $this->_error = false;
    if($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;
      if(count($params)) {
        foreach($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }
      if($this->_query->execute()) {
        $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
        $this->_count = $this->_query->rowCount();
      } else {
        $this->_error = true;
      }
    }
    return $this;
  }
  public function action1($action, $table, $where = array(),$relation=null){
      $value=array();
      $sd=array();
      // print_r($where);
      if(is_array(current($where))){
        foreach($where as $ar){
            $value[]=$ar[2];
            $sd[]=" {$ar[0]} {$ar[1]} ? ";
        }
        $field=implode(' AND ',$sd);
      }
      else{
        $field=implode(' = ? AND ',array_keys($where))." = ?";
        $value=array_values($where);
      }
      $sql = "{$action} FROM {$table} WHERE {$field}";
      if(isset($relation)){
      $sql=$sql."AND {$relation[0]} = {$relation[1]}";
      }
      if (!$this->query($sql, $value)->error()) {
        return $this;
      }
      return false;
  }
//   public function action2($action, $table, $where = array(),$relation=null){
//     $value=array();
//     $sd=array();
//     foreach($where as $ar){
//         $value[]=$ar[2];
//         $sd[]=" {$ar[0]} {$ar[1]} ? ";
//     }
//     $field=implode(' AND ',$sd);
//     $sql = "{$action} FROM {$table} WHERE {$field}";
//     if(isset($relation)){
//     $sql=$sql."AND {$relation[0]} = {$relation[1]}";
//     }
//     return array($sql,$value);
// }
  public function action($action, $table, $where = array())
  {
    $operators = array('=','>','<','>=', '<=');
    if (count($where) === 3) {
      $field    = $where[0];
      $operator = $where[1];
      $value    = $where[2];
      // echo 'lllllllllldddddddd';
    if (in_array($operator, $operators)) {
      $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
      // echo $sql;
      if (!$this->query($sql, array($value))->error()) {
        return $this;
      }
    }
  }
    if (count($where) === 6) {

  if (in_array($where[1], $operators)) {
    $sql = "{$action} FROM {$table} WHERE {$where[0]} {$where[1]} ? AND {$where[3]} {$where[4]} ?";
    if (!$this->query($sql, array( $where[2],$where[5]))->error()) {
      return $this;
      }
    }
  }
    return false;
  }

  public function get($table, $where, $field='*',$relation=null){
    $field=(is_array($field))? implode(", ",$field): '*';
    $table=(is_array($table))? implode(", ",$table): $table;
    // print_r($where);
    if(is_array(current($where))){
      return $this->action1('SELECT '.$field, $table, $where, $relation);
    }
    else{
    return $this->action1('SELECT '.$field, $table, $where);}
  }
 
  // public function get1($table, $where)
  // {
  //   return $this->action1('SELECT *', $table, $where);
  // }

  public function delete($table, $where)
  {
    return $this->action('DELETE', $table, $where);
  }
  public function getcount($field, $table, $where){
    return $this->action1("SELECT COUNT({$field}) as n", $table, $where)->first()->n;
  }


  public function insert($table, $fields = array())
  {
      $keys = array_keys($fields);
      $values = null;
      $x = 1;
      foreach($fields as $field) {
        $values .= '?';
        if($x < count($fields)) {
          $values .= ', ';
        }
        $x++;
      }
      $sql = "INSERT INTO {$table} (`" . implode('`, `' , $keys) . "`) VALUES ({$values})";

      if(!$this->query($sql, $fields)->error()) {
        return true;
      }
    return false;
  }
  

  public function update($table, $fields, $where)
  {
    $set = '';
    $x = 1;
    foreach($fields as $name => $value) {
      $set .= "{$name} = ?";
      if($x < count($fields)) {
        $set .= ', ';
      }
      $x++;
    }
    $sd=array();
    // print_r($where);
    foreach($where as $ar){
        $sd[]=" `{$ar[0]}` {$ar[1]} '{$ar[2]}' ";
        // print_r($sd);
    }
    $wh=implode(' AND ',$sd); 
    $sql = "UPDATE `{$table}` SET {$set} WHERE {$wh}";
    //echo $sql;
    if (!$this->query($sql, $fields)->error()) {
      return true;
    }
    return false;
  }

public function updatemultiple($table, $content){
  $key=array_keys($content);
  $wh=implode(', ',$key);
  $ke=array();
  foreach($key as $k){
      $ke[]="{$k}=VALUES($k)";
  }
  $sd=array();
  for ($x = 0; $x <count($content[$key[0]]); $x++){
      $ds=array();
      foreach($content as $arr){
      $ds[]="'{$arr[$x]}'";
      }
      $ds=implode(', ',$ds);
      $sd[]= "({$ds})";
  }
  $ts=implode(' , ',$sd);
  $ks=implode(', ',$ke);
  $sql="INSERT INTO `{$table}` ({$wh}) VALUES $ts ON DUPLICATE KEY UPDATE {$ks}";
  if (!$this->query($sql, array())->error()) {
    return true;
  }
  return false;
}

  public function results()
  {
    return $this->_results;
  }

  public function first()
  {
    return $this->results()[0];
  }

  public function error()
  {
    return $this->_error;
  }

  public function count()
  {
    return $this->_count;
  }

  public function getpatients($date){
    $sql="SELECT id, IF((id IN (SELECT physio FROM `appoinments` WHERE next={$date})),(SELECT COUNT(*) FROM appoinments WHERE id=physio AND next={$date}) , '0') as count FROM physio";
    if (!$this->query($sql)->error()) {
      return $this->results();
    }
    return false;
  }
  public function getpatients1(){
    $sql="SELECT * FROM `physio`, `appoinments` WHERE id=physio";
    if (!$this->query($sql)->error()) {
      return $this->results();
    }
    return false;
  }
}
