<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 
 */
class GetWorker extends CI_Controller
{
	
	public function index()
	{
		$firmID=$_GET["firmID"];
		if (!$this->checkFirmID($firmID)) {
			return;
		};

		$rows=DB::select('workResult',['*'],[
			"firmID"=>$firmID
		]);

        $i=0;
        $one=array();
        $one["count"]=0;
		foreach ($rows as $row) {
			$object =  json_decode( json_encode($row,JSON_UNESCAPED_UNICODE),TRUE);
			$one["".$i]=$object;
			$i++;
		}
		$one["count"]=count($one)-1;

        $this->json(json_encode($one,JSON_UNESCAPED_UNICODE));
	}

	public function checkFirmID($id)
    {
    	$rows=DB::select("company",['*'],'companyID ='.$id);
    	if (null==$rows) {
    		$this->json([
    			'code'=>4,
    			'error'=>"there is not a company which has this companyID "
    		]);
    		return false;
    	};
    	return true;
    }
}
?>