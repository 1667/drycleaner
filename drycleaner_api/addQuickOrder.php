<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	
	if(!isset($_REQUEST["UserName"]) ||
	   !isset($_REQUEST["ProvinceCode"]) ||
	   !isset($_REQUEST["CityCode"]) ||
	   !isset($_REQUEST["RegionCode"]) ||
	   !isset($_REQUEST["DetailAddress"]) ||
	   !isset($_REQUEST["PhoneNumber"]) ||
	   !isset($_REQUEST["PreTel"]) ||
	   !isset($_REQUEST["Tel"]) ||
	   !isset($_REQUEST["LaterTel"]) ||
	   !isset($_REQUEST["GetDate"]) ||
	   !isset($_REQUEST["GetTime"]) ||
	   !isset($_REQUEST["PayWay"]) ||
	   !isset($_REQUEST["DeliverType"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "addQuickOrder";

	if($bCheckSuccess)
	{
		$UserName = $_REQUEST["UserName"];
		$ProvinceCode = $_REQUEST["ProvinceCode"];
		$CityCode = $_REQUEST["CityCode"];
		$RegionCode = $_REQUEST["RegionCode"];
		$DetailAddress = $_REQUEST["DetailAddress"];
		$PhoneNumber = $_REQUEST["PhoneNumber"];
		$PreTel = $_REQUEST["PreTel"];
		$Tel = $_REQUEST["Tel"];
		$LaterTel = $_REQUEST["LaterTel"];
		$GetDate = $_REQUEST["GetDate"];
		$GetTime = $_REQUEST["GetTime"];
		$PayWay = $_REQUEST["PayWay"];
		$DeliverType = $_REQUEST["DeliverType"];
		$now_time = date('Y-m-d H:i:s',time());
		
		$Result = 0;
		$ErrDescription = "添加会员订单成功";
		
		$config[DAOIMPL]->addQuickOrder(array("UserName"=>$UserName, 
											  "Province"=>$ProvinceCode,
										  	  "City"=>$CityCode,
										  	  "Region"=>$RegionCode,
										      "DetailAddress"=>$DetailAddress,
										      "PhoneNumber"=>$PhoneNumber,
										      "PreTel"=>$PreTel,
										  	  "Tel"=>$Tel,
										  	  "LaterTel"=>$LaterTel,
										  	  "getdate"=>$GetDate,
										  	  "gettime"=>$GetTime,
										  	  "CreateTime"=>$now_time,
											  "Status"=>0x0001));
		
		$ID = $config[DAOIMPL]->getLastID("orders_temp");
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>