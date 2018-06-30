<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;


class DeleteEntryForm extends CI_Controller
{
	public function index()
	{
		$old=null;
		$new=null;
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

		$rows1=DB::select('workInfo',['*'],["jobID"=>$jobID]);
        if (null==$rows1) {
			$this->json([
				'code'=>-2,
				'error'=>'this job is not existent'
			]);
			return;
		};

		foreach ($rows1 as $row) {
			$old=$row->entryForm;
			$firmID=$row->firmID;
			break;
		}

        $old=explode("&", $old);
		$i=0;
		//计数字防止无限增长
		foreach ($old as $one) {
			if ($one!=$jobID) {
				if ($i==0) {
					$new=$one;
				}else{
				   $new=$new."&".$one;
			    }
				$i++;
			}
		}
        DB::Update("workInfo",["entryForm"=>$new],"jobID =".$jobID);

        DB::delete("workResult",[
        	'jobID'=>$jobID,
        	'studentID'=>$studentID
        ]);

		$this->json([
			"code"=>0,
			"success"=>"success !!"
		]);

	}
}
?>