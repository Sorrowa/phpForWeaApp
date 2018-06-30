<?php


use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 获取工作信息
 */
class GetWorkInfo extends CI_Controller
{
	//不好意思，降低了容错率
	public function index()
	{
		//如果写成括号，那么会被当成函数进行运行
		$code=$_GET["code"];
		$rows=null;
		//选择查询信息的方法
        switch ($code) {
        	case 1:
        	    $areacode=$_GET["area"];
                $area=$this->getArea($areacode);
                if ($area==null) {
                    $this->json([
                    'code'=>10,
                    'error'=>'error number of area was sent'
                ]);
                    return;
                };
        		$rows = DB::select('workInfo', ['*'], 'area = \'' .$area.'\'');
        		break;
        	case 2:
        	    $jobTypeCode=$_GET["jobType"];
                $jobType=$this->getJobType($jobTypeCode);
                if ($jobType==null) {
                    $this->json([
                    'code'=>11,
                    'error'=>'error number of jobType was sent'
                ]);
                    return;
                };
        		$rows = DB::select('workInfo', ['*'], 'jobType = \''.$jobType.'\'');
        		break;
        	case 3:
        	    $areacode=$_GET["area"];
                $area=$this->getArea($areacode);
                if ($area==null) {
                    $this->json([
                    'code'=>10,
                    'error'=>'error number of area was sent'
                ]);
                    return;
                };
        	    $jobTypeCode=$_GET["jobType"];
                $jobType=$this->getJobType($jobTypeCode);
                if ($jobType==null) {
                    $this->json([
                    'code'=>11,
                    'error'=>'error number of jobType was sent'
                ]);
                    return;
                };
        		$rows = DB::select('workInfo', ['*'], 'area =\''.$area.'\' and jobType = \''.$jobType.'\'');
        		break;

            case 4:
                $jobID=$_GET["jobID"];
                if ($jobID==null) {
                    $this->json([
                    'code'=>12,
                    'error'=>'we don\'t have this job!'
                ]);
                    return;
                };
                $rows = DB::select('workInfo', ['*'], 'jobID ='.$jobID);
                break;

            case 5:
                $firmID=$_GET["firmID"];
                if (!$this->checkFirmID($firmID)) {
                    $this->json([
                    'code'=>13,
                    'error'=>'we don\'t have this firm!'
                ]);
                    return;
                };
                $rows = DB::select('workInfo', ['*'], 'firmID ='.$firmID);
                break;

            case 6:
            //获取所有信息
                $rows = DB::select('workInfo', ['*'], []);
                break;
        	default:
        		$this->json([
        			'code'=>9,
        			'error'=>'传入了错误的寻找类型码'
        		]);
        		return;
        		break;
        };

        if ($rows==null) {
            $this->json([
                "code"=>14,
                "error"=>"no job"
            ]);
            return;
        }

        $one=array();


        $i=1;
        $one["count"]=0;
        foreach($rows as $row)
        {

            $row->entryForm=explode('&', $row->entryForm);
            //这一步将stdClass转化为array
            $object =  json_decode( json_encode($row,JSON_UNESCAPED_UNICODE),TRUE);
          
            $one["".$i]=$object;
            $i++;
            // $this->json($object);
        };

        $one["count"]=count($one)-1;

        $this->json(json_encode($one,JSON_UNESCAPED_UNICODE));

	}

/*
*查询内容rows信息
*/
function getArea($AreaNumber){
    switch ($AreaNumber) {
        case '1':
            return '金牛区';
        case '2':
            return '青羊区';
        case '3':
            return '锦江区';
        case '4':
            return '武侯区';
        case '5':
            return '成华区';
        case '6':
            return '龙泉驿区';
        case '7':
            return '青白江区';
        case '8':
            return '新都区';
        case '9':
            return '温江区';
        default:
            return null;
        }
}


function getJobType($typeCode){
    switch ($typeCode) {
        case '1':
            return 'IT';
        case '2':
            return '金融';
        case '3':
            return '教育';
        case '4':
            return '劳动';
        case '5':
            return '医学';

        default:
            return null;
    };
}

private function checkFirmID($id)
    {
        $rows=DB::select("company",['*'],'companyID ='.$id);
        if (null==$rows) {
            return false;
        };
        return true;
    }

}
?>