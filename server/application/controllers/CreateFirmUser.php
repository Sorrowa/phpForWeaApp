<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 
 */
class CreateFirmUser extends CI_Controller
{
	
	public function index()
	{

    
    
	$firmName=$_GET["firmName"];
    if($firmName==null){
      $firmName="a";
    }
	$companyKey=$_GET["key"];

    $one=null;

    $rows=DB::select('company',['*'],["companyKey"=>$companyKey]);
    foreach ($rows as $row ) {
    	$one=$row;
    	break;
    };

    if (null!=$rows) {
      $this->json([
       "code"=>1,
       "success"=>"already",
       "companyID"=>$one->companyID
      ]);
      return;
    }


    DB::insert('company',["companyKey"=>$companyKey,"name"=>$firmName]);

    $rows=DB::select('company',['*'],["companyKey"=>$companyKey]);

    foreach ($rows as $row ) {
    	$one=$row;
    	break;
    };
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
       "companyID"=>$one->companyID
      ]);
    }
	}
}
?>