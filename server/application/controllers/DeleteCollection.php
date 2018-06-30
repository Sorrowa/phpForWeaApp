<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 删除收藏的某个工作
 */
class DeleteCollection extends CI_Controller
{
	
	public function index()
	{
		$old=null;
		$new=null;
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
  //如果此时进行工作信息的检查，如果工作信息已经不存在，那么就不能删除此条目了
  //       $rows1=DB::select('workInfo',['*'],["jobID"=>$jobID]);
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

		//然后删除信息
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
		DB::Update('student',["collection"=>$new],"studentID =".$studentID);
		$this->json([
			"code"=>0,
			"success"=>"success !!"
		]);
	}
}
?>