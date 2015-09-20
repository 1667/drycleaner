<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$bCheckSuccess = true;
	$ApiType = "addGoodsPriceShare";
	$ID = 0;
	
	if(!isset($_REQUEST["goodspriceid"]) ||
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
		$ErrDescription = "添加成功";
		
		$goodspriceid = intval($_REQUEST["goodspriceid"]);
		$sharechannel = intval($_REQUEST["sharechannel"]);
		$sharecontent = $_REQUEST["sharecontent"];
		$now_time = date('Y-m-d H:i:s',time());

		$config[DAOIMPL]->addGoodsPriceShare(array("goodspriceid"=>$goodspriceid, 
										 "sharechannel"=>$sharechannel,
										 "sharecontent"=>$sharecontent,
										 "sharetime"=>$now_time));
		$ID = $config[DAOIMPL]->getLastID("goodspriceshare");
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>