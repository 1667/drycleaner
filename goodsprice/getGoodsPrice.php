<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$ApiType = "getGoodsPrice";
	$Result = 0;
	$ErrDescription = "获取成功";
	
	if(!isset($_REQUEST["ID"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ID = intval($_REQUEST["ID"]);

	$arr_rs = $config[DAOIMPL]->getGoodsPrice($ID);
	
	if(count($arr_rs) > 0)
	{
		$Result = 0;
		$ErrDescription = "获取成功";
		
		$title = $arr_rs["title"];
		$description = $arr_rs["description"];
		$pic_count = intval($arr_rs["pic_count"]);
		$picFile_1 = $arr_rs["picFile_1"];
		$picFile_2 = $arr_rs["picFile_2"];
		$picFile_3 = $arr_rs["picFile_3"];
		$picFile_4 = $arr_rs["picFile_4"];
		$picFile_5 = $arr_rs["picFile_5"];
		$picFile_6 = $arr_rs["picFile_6"];
		$picFile_7 = $arr_rs["picFile_7"];
		$picFile_8 = $arr_rs["picFile_8"];
		$view_count = intval($arr_rs["view_count"]);
		$create_time = $arr_rs["create_time"];
		$update_time = $arr_rs["update_time"];
	}
	else
	{
		$Result = -2;
		$ErrDescription = "无此ID号";
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "id"=>$ID, "title"=>$title, "description"=>$description, "pic_count"=>$pic_count, "picFile_1"=>$picFile_1, "picFile_2"=>$picFile_2, "picFile_3"=>$picFile_3, "picFile_4"=>$picFile_4, "picFile_5"=>$picFile_5, "picFile_6"=>$picFile_6, "picFile_7"=>$picFile_7, "picFile_8"=>$picFile_8, "view_count"=>$view_count, "create_time"=>$create_time, "update_time"=>$update_time));
?>