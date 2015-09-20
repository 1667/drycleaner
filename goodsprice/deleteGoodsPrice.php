<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$bCheckSuccess = true;
	$ApiType = "deleteGoodsPrice";
	$ID = 0;
	
	if(!isset($_REQUEST["ID"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "删除成功";
		
		$ID = intval($_REQUEST["ID"]);

		$config[DAOIMPL]->deleteGoodsPrice($ID);
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>