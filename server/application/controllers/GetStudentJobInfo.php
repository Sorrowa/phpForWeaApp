<?php

use QCloud_WeApp_SDK\Mysql\Mysql as DB;

/**
 * 获取对应学生的工作详细信息
 */
class GetStudentJobInfo extends CI_Controller
{
	
	public function index()
	{
		$studnetID=$_GET["studentID"];
		//查询对应studentID的工作结果
		$rowsOne=DB::select('workResult',['*'],'studentID ='.$studnetID);
		$jobIDs=array();
		foreach ($rowsOne as $row) {
			$jobIDs[]=$row->jobID;
		}
   
        $i=0;
		$one=array();
        foreach ($jobIDs as $jobID) {
        	$rows=DB::select('workInfo',['*'],'jobID='.$jobID);
        	foreach ($rows as $row) {
        		$row->entryForm=explode('&', $row->entryForm);
            //这一步将stdClass转化为array
                $object =  json_decode( json_encode($row,JSON_UNESCAPED_UNICODE),TRUE);
                $one[$i]=$object;
                $i++;
        	}
        }
        //总数统计
        $one["count"]=$i;

        $this->json(json_encode($one,JSON_UNESCAPED_UNICODE));
		// $rows = DB::select('workInfo', ['*'], 'jobID ='.$jobID);

	}
}
?>