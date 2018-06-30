<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 
 */
class AddEntryForm extends CI_Controller
{
	
	public function index()
	{
		$old=null;
		$firmID=null;

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

        $name=null;

		foreach ($rows as $row) {
			$name=$row->name;
		};

		$rows1=DB::select('workInfo',['*'],["jobID"=>$jobID]);
        if (null==$rows1) {
			$this->json([
				'code'=>-2,
				'error'=>'this job is not existent'
			]);
			return;
		};

		foreach ($rows1 as $row) {
			$firmID=$row->firmID;
			$old=$row->entryForm;
			break;
		}

		if (in_array($studentID, explode("&", $old))) {
			$this->json([
        	"code"=>-3,
        	"success"=>"already existed"
        ]);
			return;
		}

        if ($old==null) {
        	$old=$studentID;
        }else{
        	$old.="&".$studentID;
        }

        DB::Update("workInfo",["entryForm"=>$old],"jobID =".$jobID);
        
        $this->json([
        	"code"=>0,
        	"success"=>"you get it!"
        ]);

        DB::insert("workResult",[
        	'jobID'=>$jobID,
        	'studentID'=>$studentID,
        	'firmID'=>$firmID,
        	'name'=>$name,
          'result'=>"等待审核"
        ]);

	}
}
?>