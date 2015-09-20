<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$ApiType = "getGoodsPriceShare";
	$Result = 0;
	$ErrDescription = "获取成功";
	
	if(!isset($_REQUEST["ID"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ID = intval($_REQUEST["ID"]);

	$arr_rs = $config[DAOIMPL]->getGoodsPriceShare($ID);
	
	if(count($arr_rs) > 0)
	{
		$Result = 0;
		$ErrDescription = "获取成功";
		$goodspriceid = intval($arr_rs["goodspriceid"]);
		$sharetime = $arr_rs["sharetime"];
		$sharechannel = intval($arr_rs["sharechannel"]);
		$sharecontent = $arr_rs["sharecontent"];
	}
	else
	{
		$Result = -2;
		$ErrDescription = "无此ID号";
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "id"=>$ID, "goodspriceid"=>$goodspriceid, "sharetime"=>$sharetime, "sharechannel"=>$sharechannel, "sharecontent"=>$sharecontent));
?>