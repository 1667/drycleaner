<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$bCheckSuccess = true;
	$ApiType = "updateGoodsPrice";
	$ID = 0;
	
	if(!isset($_REQUEST["ID"]) ||
	   !isset($_REQUEST["Title"]) ||
	   !isset($_REQUEST["Description"]) ||
	   !isset($_REQUEST["PicCount"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "修改成功";
		
		$ID = intval($_REQUEST["ID"]);
		$Title = $_REQUEST["Title"];
		$Description = $_REQUEST["Description"];
		$pic_count = intval($_REQUEST["PicCount"]);
		
		if($pic_count >= 1)
		{
			$pic_file_1 = $_REQUEST["PicFile1"];
		}
		if($pic_count >= 2)
		{
			$pic_file_2 = $_REQUEST["PicFile2"];
		}
		if($pic_count >= 3)
		{
			$pic_file_3 = $_REQUEST["PicFile3"];
		}
		if($pic_count >= 4)
		{
			$pic_file_4 = $_REQUEST["PicFile4"];
		}
		if($pic_count >= 5)
		{
			$pic_file_5 = $_REQUEST["PicFile5"];
		}
		if($pic_count >= 6)
		{
			$pic_file_6 = $_REQUEST["PicFile6"];
		}
		if($pic_count >= 7)
		{
			$pic_file_7 = $_REQUEST["PicFile7"];
		}
		if($pic_count >= 8)
		{
			$pic_file_8 = $_REQUEST["PicFile8"];
		}
		
		$view_count = 0;
		$now_time = date('Y-m-d H:i:s',time());

		$config[DAOIMPL]->updateGoodsPrice($ID, array("title"=>$Title, 
										 			"description"=>$Description,
										 		   	"pic_count"=>$pic_count,
										 		   	"picFile_1"=>$pic_file_1,
													"picFile_2"=>$pic_file_2,
										 		   	"picFile_3"=>$pic_file_3,
										 		  	"picFile_4"=>$pic_file_4,
										 		   	"picFile_5"=>$pic_file_5,
										 		   	"picFile_6"=>$pic_file_6,
										 		   	"picFile_7"=>$pic_file_7,
										 		   	"picFile_8"=>$pic_file_8,
										 		    "update_time"=>$now_time));
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>