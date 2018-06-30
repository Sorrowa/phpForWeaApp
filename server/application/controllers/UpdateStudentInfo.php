<?php

use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class UpdateStudentInfo extends CI_Controller
{
	public function index(){
		$code=$_POST["code"];
		/**
		*检验是否发生了数据的变化
		*/
		if ($code==0) {
	        $this->json([
			'code'=>'0',
			'success'=>'nothing change'
		    ]);
			return;
		};
		//获取数据,并进行类型检查
		$studentID=$_POST["studentID"];

		if (!is_numeric($studentID)) {
			$this->json([
			'code'=>'20',
			'error'=>'ID type wrong'
		    ]);
		    return;
		};

		if(mb_strlen($studentID)>15){
			$this->json([
			'code'=>'21',
			'error'=>'ID is too long'
		    ]);
		    return;
		};

		$name=$_POST["name"];

		if(mb_strlen($name,'utf8')>10){
			$this->json([
			'code'=>'30',
			'error'=>'name is too long'
		    ]);
		    return;
		};

		if (preg_match('/[0-9]/', $name)) {
			$this->json([
			'code'=>'31',
			'error'=>'name type wrong'
		    ]);
		    return;
		};

		$birthday=$_POST["birthday"];

		$telephone=$_POST["telephone"];
        //判断是否为纯数字
		if (!is_numeric($telephone)) {
			$this->json([
			'code'=>'40',
			'error'=>'phone type wrong'
		    ]);
		    return;
		};

		//判断长度是否合法
		if (mb_strlen($telephone,'utf-8')!=11) {
			$this->json([
				'code'=>'41',
				'error'=>'please check the phone number.'
			]);
			return;
		};

		$mail=$_POST["mail"];
        //判断长度是否合法
		if (mb_strlen($mail,'utf-8')>80) {
			$this->json([
				'code'=>'50',
				'error'=>'please check the mail,it\'s too long .'
			]);
			return;
		};
		//判断是否包含中文
        if (preg_match('/['.chr(0xa1).'-'.chr(0xff).']/', $mail)) {
			$this->json([
			'code'=>'52',
			'error'=>'mail type wrong'
		    ]);
		    return;
		};
        //判断基本格式是否正确
		if((!strpos($mail,'@'))||(!strpos($mail,'.com'))){
			$this->json([
				'code'=>'51',
				'error'=>'please check the mail'
			]);
			return;
		};
		//判断基本顺序是否一致
		if (strpos($mail,'@')>strpos($mail,'.com')||(strpos($mail,'.com')-strpos($mail,'@')==1)) {
			$this->json([
				'code'=>'53',
				'error'=>'please check the mail order'
			]);
			return;
		};
        
		$sexid=$_POST["sexid"];

		if (!is_numeric($sexid)) {
			$this->json([
			'code'=>'60',
			'error'=>'sex type wrong'
		    ]);
		    return;
		};

		$height=$_POST["height"];

		$school=$_POST["school"];

		$qq=$_POST["qq"];
        //判断是否为纯数字
		if (!is_numeric($qq)) {
			$this->json([
			'code'=>'70',
			'error'=>'qq type wrong'
		    ]);
		    return;
		};
		$introduction=$_POST["introduction"];
		//判断长度是否合法
		if (mb_strlen($introduction,'utf-8')>400) {
			$this->json([
				'code'=>'80',
				'error'=>'introduction is too long.'
			]);
			return;
		};

		$rows = DB::update('student', ['name' => $name,
	     "birthday"=>$birthday,"telephone"=>$telephone,'mail'=>$mail,'sexid'=>$sexid,
	     'height'=>$height,'school'=>$school,'qq'=>$qq,'introduction'=>$introduction],
		 "studentID = ".$studentID);

		if ($rows==0) {
			$this->json([
			'code'=>'8',
			'error'=>'there is no this student'
		]);
			return;
		};

		$this->json([
			'code'=>'1',
			'success'=>'change ok'
		]);

	}
};

?>