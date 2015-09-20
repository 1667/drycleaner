<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;

	if(!isset($_REQUEST["TypeID"]) ||
	   !isset($_REQUEST["MaterialQuality"]) ||
	   !isset($_REQUEST["Style"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ApiType = "getClothingGoodsSummary";
	
	if($bCheckSuccess)
	{
		$TypeID = $_REQUEST["TypeID"];
		$MaterialQuality = $_REQUEST["MaterialQuality"];
		$Style = $_REQUEST["Style"];
		
		$Result = 0;
		$ErrDescription = "获取成功";
		$Count = $config[DAOIMPL]->getGoodsCountEx($TypeID, $MaterialQuality, $Style);
		$summarys_rs = $config[DAOIMPL]->getGoodssEx(1,-1,$TypeID,$MaterialQuality,$Style);
		for($i = 0 ; $i < $Count ; $i++)
		{
			$row = mysql_fetch_array($summarys_rs);
			$summarys_array[$i] = array("MainTypeID"=>$TypeID, "TypeID"=>$row["ServiceTypeID"], "ClothingGoodsID"=>$row["id"]);
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $summarys_array));
?>