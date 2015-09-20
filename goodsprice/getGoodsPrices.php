<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$ApiType = "getGoodsPrices";
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

	$Count = $config[DAOIMPL]->getGoodsPriceCount();
	$ads_rs = $config[DAOIMPL]->getGoodsPrices($page,$number_per_page);
	for($i = 0 ; $i < $Count ; $i++)
	{
		$row = mysql_fetch_array($ads_rs);
		$arr_goodsprices[$i] = array("id"=>$row["id"],
									 "title"=>$row["title"],
									 "description"=>$row["description"],
									 "pic_count"=>$row["pic_count"],
								     "pic_file_1"=>$row["picFile_1"],
								 	 "pic_file_2"=>$row["picFile_2"],
								 	 "pic_file_3"=>$row["picFile_3"],
								 	 "pic_file_4"=>$row["picFile_4"],
								     "pic_file_5"=>$row["picFile_5"],
								 	 "pic_file_6"=>$row["picFile_6"],
								 	 "pic_file_7"=>$row["picFile_7"],
								 	 "pic_file_8"=>$row["picFile_8"]);
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $arr_goodsprices));
?>