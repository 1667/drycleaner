<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["OrderID"]) ||
	   !isset($_REQUEST["RemandDate"]) ||
	   !isset($_REQUEST["RemandTime"]) ||
	   !isset($_REQUEST["Memo"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "setRemandTime";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$OrderID = $_REQUEST["OrderID"];
		$RemandDate = $_REQUEST["RemandDate"];
		$RemandTime = $_REQUEST["RemandTime"];
		$Memo = $_REQUEST["Memo"];
		
		$member = $config[DAOIMPL]->getMemberByName($Account);
		$order = $config[DAOIMPL]->getOrder($OrderID);
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
				$ErrDescription = "订单不存在";
			}
			else
			{
				if($order["UserID"] != $member["id"])
				{
					$Result = -4;
					$ErrDescription = "此订单不属于该会员";
				}
				else
				{
					$remand = $config[DAOIMPL]->getRemandByOrderID($OrderID);
					if(count($remand) > 0)
					{
						$config[DAOIMPL]->updateRemand($remand["id"], array("OrderID"=>$OrderID ,"RemandDate"=>$RemandDate ,"RemandTime"=>$RemandTime ,"Memo"=>$Memo,"Status"=>1));
					}
					else
					{
						$config[DAOIMPL]->addRemand(array("OrderID"=>$OrderID ,"RemandDate"=>$RemandDate ,"RemandTime"=>$RemandTime ,"Memo"=>$Memo,"Status"=>1));
					}
				
					$Result = 0;
					$ErrDescription = "设置预约送回成功";
				}
			}	
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "OrderID"=>$_REQUEST["OrderID"]));
?>