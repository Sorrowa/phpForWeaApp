<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 删除工作信息
 */
class DeleteWorkInfo extends CI_Controller
{
	
	public function index()
	{

		$firmID=$_POST["firmID"];

		if (!$this->checkFirmID($firmID)) {
			$this->json([
                'code'=>1,
                'error'=>'we don\'t have this firm!'
                ]);
            return;
		}

		$jobID=$_POST["jobID"];

		if(!$this->checkJobID($jobID)){
			$this->json([
                'code'=>2,
                'error'=>'we don\'t have this job!'
                ]);
            return;
		}

		$rows=DB::select("workInfo",['*'],'jobID ='.$jobID);
        
        $one=null;

		foreach ($rows as $row) {
			$one=$row->firmID;
			break;
		}

		if ($one!=$firmID) {
			$this->json([
                'code'=>3,
                'error'=>'you don\'t have the right'
                ]);
            return;
		}

		$rows = DB::delete('workInfo', "jobID =".$jobID);
        
        if ($rows!=null) {
        	$this->json([
                'code'=>0,
                'success'=>'you get it'
                ]);
            return;
        }else{
        	$this->json([
                'code'=>4,
                'error'=>'some unknown things happenned!'
                ]);
            return;
        }

        
	}


	private function checkFirmID($id)
    {
        $rows=DB::select("company",['*'],'companyID ='.$id);
        if (null==$rows) {
            return false;
        };
        return true;
    }
    private function checkJobID($id)
    {
    	$rows=DB::select("workInfo",['*'],'jobID ='.$id);
    	if (null==$rows) {
    		return false;
    	};
    	return true;
    }
}
?>