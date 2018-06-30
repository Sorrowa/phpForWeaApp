<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

/**
 * 创建工作信息
 */
class CreateWorkInfo extends CI_Controller
{

	
	public function index()
	{
        
        $id=-1;

		$jobname=$_POST["jobname"];
        if (null==$jobname) {
        	$this->json([
				"code"=>3,
				"error"=>"jobname is null"
			]);
			return;
        }

        $firmID=$_POST["firmID"];

        if (!$this->checkFirmID($firmID)) {
        	return;
        };

        $send_out_date=$_POST["send_out_date"];

        $firm=$_POST["firm"];

        $area=$_POST["area"];
        
        $period=$_POST["freq"];

        $salary=$_POST["salary"];

        $amount=$_POST["amount"];

        $jobType=$_POST["jobType"];

        $sex=$_POST["sex"];

        $workingDate=$_POST["workingDate"];

        $workingPeriod=$_POST["workingPeriod"];

        $details=$_POST["details"];

        $workingPlace=$_POST["workingPlace"];

        $contacts=$_POST["contacts"];

        $contactWays=$_POST["contactWays"];

        DB::insert('workInfo', [
           'jobname' => $jobname,
  	       'send_out_date' => $send_out_date,
  	       'firmID'=>$firmID,
  	       'firm' => $firm,
  	       'area' => $area,
  	       'period' => $period,
  	       'salary' => $salary,
  	       'amount' => $amount,
  	       'jobType' => $jobType,
  	       'sex' => $sex,
  	       'workingDate' => $workingDate,
  	       'workingPeriod' => $workingPeriod,
  	       'details' => $details,
  	       'workingPlace' => $workingPlace,
  	       'contacts' => $contacts,
  	       'entryForm' => null,
           'contactWays'=> $contactWays
        ]);

        // $rows=DB::select('workInfo', ['*'], ['jobname' => $jobname,
  	     //   'send_out_date' => $send_out_date,
  	     //   'firm' => $firm,
  	     //   'firmID'=>$firmID,
  	     //   'area' => $area,
  	     //   'period' => $period,
  	     //   'salary' => $salary,
  	     //   'amount' => $amount,
  	     //   'jobType' => $jobType,
  	     //   'sex' => $sex,
  	     //   'workingDate' => $workingDate,
  	     //   'workingPeriod' => $workingPeriod,
  	     //   'details' => $details,
  	     //   'workingPlace' => $workingPlace,
  	     //   'contacts' => $contacts,
  	     //   'entryForm' => null]);


        // foreach ($rows as $row) {
        // 	$id=$row->jobID;
        // };

        $this->json([
        	'code'=>0,
        	'success'=>'you get it !'
        ]);
        return;
	}

	private function checkFirmID($id)
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