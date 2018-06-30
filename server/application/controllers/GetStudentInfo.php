<?php

use QCloud_WeApp_SDK\Mysql\Mysql as DB;

/**
 * 获取用户信息,URL后的参数为学生ID
 */
class GetStudentInfo extends CI_Controller
{
	
	public function index()
	{
		$data = $_SERVER["QUERY_STRING"];
		//检验内容是否为空
        if ($data==null) 
        {
        	$this->json([
                'code' => -1,
                'error' => '数据为空'
            ]);
            return;
        };
        //记录参数个数
        $i=0;

        foreach (explode('&', $data) as $value) {
        	//传入的数据过多
        	if(++$i>2){
        		$this->json([
           		'code'=>0,
           		'error'=>'不支持传入数据的格式'
           	    ]);
           	    return;
        	};

          $finalNum=explode('=', $value);
          //传入数据的名称如果错误
        	if ($finalNum[0]!='ID') {
        		$this->json([
           		'code'=>10086,
           		'error'=>'不支持传入数据的格式'
           	    ]);
           	    return;
        	};

          $ID=$finalNum[1];
          $a=preg_match('/['.chr(0xa1).'-'.chr(0xff).']/', $ID);
          $c=preg_match('/[a-zA-Z]/', $ID);
          if ($a||$c) {
        	    $this->json([
                'code' => 7,
                'error' => 'wrong type'
                ]);
                return;
            };

            

        }
        $this->selectInfo($ID);
        

	}

    //传入的参数为学生ID
	public function selectInfo($data){
		$rows = DB::select('student', ['*'], 'studentID ='.$data);
		//如果传入的ID不存在与数据库中
		if ($rows==null) {
			$this->json([
                'code' => 8,
                'error' => 'there is no this student,please check the number'
                ]);
                return;
		};

		foreach($rows as $row)
        {
            $row->collection=$this->changeCollection($row->collection);
            //这一步将stdClass转化为array
            $object =  json_decode( json_encode($row),true);
            $this->json($object);
        }

	}

    public function changeCollection($data)
    {
    	return explode('&', $data);
    }


}
?>