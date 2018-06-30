<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 更改收藏信息
 */
class AddCollection extends CI_Controller
{
	
	public function index()
	{
		$old=null;
		$studentID=$_GET["studentID"];
		$jobID=$_GET["jobID"];


		$rows=DB::select('student',['*'],["studentID"=>$studentID]);
		if (null==$rows) {
			$this->json([
				'code'=>-1,
				'error'=>'this student is not existent'
			]);
			return;
		};

		// $rows1=DB::select('workInfo',['*'],["jobID"=>$jobID]);
  //       if (null==$rows1) {
		// 	$this->json([
		// 		'code'=>-2,
		// 		'error'=>'this job is not existent'
		// 	]);
		// 	return;
		// };

		foreach ($rows as $row) {
			$old=$row->collection;
			break;
		};

		if (in_array($jobID, explode("&", $old))) {
			$this->json([
        	"code"=>-3,
        	"success"=>"already existed"
        ]);
			return;
		}

		if ($old==null) {
			$old=$jobID;
		}else{
			$old.="&".$jobID;
		}

		$jobID=$old;
		DB::Update('student',["collection"=>$jobID],"studentID =".$studentID);
		$this->json([
			"code"=>0,
			"success"=>"success !!"
		]);
	}
}
?>