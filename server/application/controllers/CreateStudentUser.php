<?php

use QCloud_WeApp_SDK\Mysql\Mysql as DB;

/**
 * 创建学生用户的后端代码
 */
class CreateStudentUser extends CI_Controller
{
	
	
	public function index()
	{
    $one=null;
    $studentKey=$_GET["key"];
    $rows=DB::select('student',['*'],["studentKey"=>$studentKey]);
    if (null!=$rows) {
      foreach ($rows as $row) {
        $one=$row;
        break;
      }
    	$this->json([
        "code"=>1,
        "success"=>"already",
        "studentID"=>$one->studentID
      ]);
    	return;
    }
    DB::insert('student',["studentKey"=>$studentKey]);
    $rows=DB::select('student',['*'],["studentKey"=>$studentKey]);

    foreach ($rows as $row) {
        $one=$row;
        break;
    }
    
    if (null==$rows) {
      $this->json([
        "code"=>-1,
        "error"=>"fail"
      ]);
      return;
    }else{
      $this->json([
        "code"=>0,
        "success"=>"get it",
        "studentID"=>$one->studentID
      ]);
    }
	}
}
?>