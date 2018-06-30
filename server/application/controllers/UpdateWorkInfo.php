<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

/**
 * 
 */
class UpdateWorkInfo extends CI_Controller
{
	
	public function index()
	{
		//对修改模式进行筛选
		$code=$_POST["code"];
		if (null==$code) {
			$this->json([
				"code"=>1,
				"error"=>"Please check the code!"
			]);
			return;
		}
		if (0==$code) {
			$this->json([
				"code"=>2,
				"success"=>"no thing change"
			]);
			return;
		};

		$jobID=$_POST["jobID"];

		if (!$this->checkJobID($jobID)) {
			return;
		};

        $jobname=$_POST["jobname"];
        if (null==$jobname) {
        	$this->json([
				"code"=>3,
				"error"=>"jobname is null"
			]);
			return;
        }

        // $firmID=$_POST["firmID"];

        // if (!$this->checkFirmID($firmID)) {
        // 	return;
        // };

        // $send_out_date=$_POST["$send_out_date"];

        // $firm=$_POST["firm"];

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

        DB::Update('workInfo',['jobname'=>$jobname,'jobType'=>$jobType,'area'=>$area,'period'=>$period,'salary'=>$salary,'amount'=>$amount,'sex'=>$sex,'workingDate'=>$workingDate,'workingPeriod'=>$workingPeriod,'details'=>$details,'workingPlace'=>$workingPlace,'contacts'=>$contacts,'contactWays'=>$contactWays],"jobID = ".$jobID);


        $this->json([
        	"code"=>0,
        	"success"=>"感触良多"
        ]);
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

    public function checkJobID($id)
    {
    	$rows=DB::select("workInfo",['*'],'jobID ='.$id);
    	if (null==$rows) {
    		$this->json([
    			'code'=>5,
    			'error'=>"there is not a job which has this companyID "
    		]);
    		return false;
    	};
    	return true;
    }

}
?>