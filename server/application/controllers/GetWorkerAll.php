<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 
 */
class GetWorkerAll extends CI_Controller
{
	
	public function index()
	{
		$firmID=$_GET['firmID'];
		$rows=DB::select('workResult',['*'],["firmID"=>$firmID]);
		$one = array();
		$i=0;
		foreach ($rows as $row) {
			$object = json_decode( json_encode($row),true);
			// print_r($object["jobID"]);
            $two=DB::select('workInfo',['*'],["jobID"=>$object["jobID"]]);
             
            $object["jobName"]=$two[0]->jobName;
            // print_r($two[0]->jobName);
			$one[$i]=$object;
			$i++;
		}
		$this->json($one);
	}
}
?>