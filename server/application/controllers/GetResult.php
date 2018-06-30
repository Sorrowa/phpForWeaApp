<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 
 */
class GetResult extends CI_Controller
{
	
	public function index()
	{
		$studentID=$_GET["studentID"];
		// if (!$this->checkJobID($jobID)) {
		// 	return;
		// };
		$rows=DB::select('workResult',['*'],[
			'studentID'=>$studentID
		]);
		$result = array();
		$i=0;
		foreach ($rows as $row) {
            //这一步将stdClass转化为array
            $object =  json_decode( json_encode($row),true);
			$result[$i]=$object;
			$i++;
		};
		if ($result==null) {
			$this->json([
				"code"=>1,
				"error"=>'no result'
			]);
			return;
		}else{
			$this->json($result);
		}


	}

	// private function checkJobID($id){
	// 	$rows=DB::select("workInfo",['*'],'jobID ='.$id);
 //    	if (null==$rows) {
 //    		$this->json([
 //    			'code'=>5,
 //    			'error'=>"there is not a job which has this companyID "
 //    		]);
 //    		return false;
 //    	};
 //    	return true;
	// }
}
?>