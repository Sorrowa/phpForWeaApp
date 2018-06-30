<?php
//PDO~
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Demo extends CI_Controller{
  public function index()
  {

    $name='';

  	$name=$_GET['demo'];


    echo $name[1];
  }
}

?>
