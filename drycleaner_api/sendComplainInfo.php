<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["Type"]) ||
	   !isset($_REQUEST["OrderSerial"]) ||
	   !isset($_REQUEST["Content"]) ||
	   !isset($_REQUEST["PhoneNumber"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ApiType = "sendComplainInfo";

	if($bCheckSuccess)
	{
		// input
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$Type = intval($_REQUEST["Type"]);
		$OrderSerial = $_REQUEST["OrderSerial"];
		$Content = $_REQUEST["Content"];
		$PhoneNumber = $_REQUEST["PhoneNumber"];
		
		$member = $config[DAOIMPL]->getMemberByName($Account);
		$order = $config[DAOIMPL]->getOrderBySerial($OrderSerial);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			if(count($order) <= 0)
			{
				$Result = -3;
				$ErrDescription = "订单号不存在";
			}
			else if($order["UserID"] != $member["id"])
			{
				$Result = -4;
				$ErrDescription = "此订单不属于该用户";
			}
			else
			{
				$Result = 0;
				$ErrDescription = "发送投诉信息成功";
				$config[DAOIMPL]->addComplain(array("UserID"=>$member["id"], "OrderID"=>$order["id"], "Type"=>$Type, "Content"=>$Content, "PhoneNumber"=>$PhoneNumber, "ComplainTime"=>date("Y-m-d H:i:s", time())));
			}
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription));
?>