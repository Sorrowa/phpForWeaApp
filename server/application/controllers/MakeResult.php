<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 
 */
class MakeResult extends CI_Controller
{
	
	public function index()
	{
		$jobID=$_POST["jobID"];
		$studentID=$_POST["studentID"];
		$result=$_POST["result"];

		$result=$this->getWorkResult($result);

		if ($result==-1) {
			$this->json([
				'code'=>-1,
				'error'=>'unknown reslut number'
			]);
			return;
		}

		DB::Update('workResult',["result"=>$result,"date"=>date("Y-m-d")],[
			"jobID"=>$jobID,
			"studentID"=>$studentID
		]);

		$this->json([
			"code"=>0,
			"success"=>"you get it"
		]);
	}

	private function getWorkResult($one){
		switch ($one) {
			case '1':
				return "已通过";
				break;
			case '2':
				return "未通过";
				break;
			
			default:
				return -1;
				break;
		}
	}
}
?>