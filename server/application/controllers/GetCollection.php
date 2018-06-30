<?php
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
/**
 * 
 */
class GetCollection extends CI_Controller
{
	
	public function index()
	{
		$studentID=$_GET["studentID"];
		$rows = DB::select('student', ['*'], 'studentID ='.$studentID);
		if ($rows==null) {
			$this->json([
				"code"=>-1,
				"error"=>"this student is not existent"
			]);
			return;
		}
		$one=null;
		foreach ($rows as $row) {
			$one=explode("&", $row->collection);
		};
		$this->json($one);
	}
}
?>