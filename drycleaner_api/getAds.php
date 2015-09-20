<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	// input
	$bCheckSuccess = true;
	
	// output
	$ApiType = "getAds";
	$Result = 0;
	$ErrDescription = "获取成功";
	$Count = $config[DAOIMPL]->getEventCount();
	$ads_rs = $config[DAOIMPL]->getEvents(1,-1);
	for($i = 0 ; $i < $Count ; $i++)
	{
		$row = mysql_fetch_array($ads_rs);
		$ads_array[$i] = array("ID"=>$row["id"],"PicUrl"=>$row["PicFileName"]);
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $ads_array));
?>