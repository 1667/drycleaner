<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$bCheckSuccess = true;
	$ApiType = "updateGoodsPriceShare";
	$ID = 0;
	
	if(!isset($_REQUEST["ID"]) ||
	   !isset($_REQUEST["goodspriceid"]) ||
	   !isset($_REQUEST["sharechannel"]) ||
	   !isset($_REQUEST["sharecontent"]))
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
		$goodspriceid = intval($_REQUEST["goodspriceid"]);
		$sharechannel = intval($_REQUEST["sharechannel"]);
		$sharecontent = $_REQUEST["sharecontent"];

		$config[DAOIMPL]->updateGoodsPriceShare($ID, array("goodspriceid"=>$goodspriceid, 
										 "sharechannel"=>$sharechannel,
										 "sharecontent"=>$sharecontent));
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>