<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	// input
	$bCheckSuccess = true;
	
	// output
	$ApiType = "getDryTipsSummary";
	$Result = 0;
	$ErrDescription = "获取成功";
	$Count = $config[DAOIMPL]->getDryTipCount();
	$summarys_rs = $config[DAOIMPL]->getDryTips(1,-1);
	for($i = 0 ; $i < $Count ; $i++)
	{
		$row = mysql_fetch_array($summarys_rs);
		$summarys_array[$i] = array("ID"=>$row["id"],"Title"=>$row["Title"]);
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $summarys_array));
?>