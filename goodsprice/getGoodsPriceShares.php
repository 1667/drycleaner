<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$ApiType = "getGoodsPriceShares";
	$Result = 0;
	$ErrDescription = "获取成功";
	$page = 1;
	$number_per_page = -1;
	if(isset($_REQUEST["page"]))
	{
		$page = intval($_REQUEST["page"]);
	}
	if(isset($_REQUEST["number_per_page"]))
	{
		$number_per_page = intval($_REQUEST["number_per_page"]);
	}

	$Count = $config[DAOIMPL]->getGoodsPriceShareCount();
	$ads_rs = $config[DAOIMPL]->getGoodsPriceShares($page,$number_per_page);
	for($i = 0 ; $i < $Count ; $i++)
	{
		$row = mysql_fetch_array($ads_rs);
		$arr_goodspriceshares[$i] = array("id"=>$row["id"],
									 "goodspriceid"=>$row["goodspriceid"],
									 "sharetime"=>$row["sharetime"],
									 "sharechannel"=>$row["sharechannel"],
								     "sharecontent"=>$row["sharecontent"]);
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $arr_goodspriceshares));
?>