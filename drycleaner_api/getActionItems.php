<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";
	
	$bCheckSuccess = true;
	
	// input
	if(!isset($_REQUEST["Type"]) ||
	   (intval($_REQUEST["Type"]) != 1 &&
		intval($_REQUEST["Type"]) != 2 &&
		intval($_REQUEST["Type"]) != 3))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ApiType = "getActionItems";
	
	if($bCheckSuccess)
	{
		$Type = intval($_REQUEST["Type"]);
		
		// output
		$Result = 0;
		$ErrDescription = "获取成功";
	
		$Count = $config[DAOIMPL]->getActionCount($Type);
		$actions_rs = $config[DAOIMPL]->getActions($Type, 1,-1);
		for($i = 0 ; $i < $Count ; $i++)
		{
			$row = mysql_fetch_array($actions_rs);
			$items_array[$i] = array("ID"=>$row["id"],"ClothingID"=>$row["ClothingGoodsID"]);
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ItemType"=>$Type, "Count"=>$Count, $items_array));
?>