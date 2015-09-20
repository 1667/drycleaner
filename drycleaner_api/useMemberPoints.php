<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["Points"]) ||
	   !isset($_REQUEST["OrderID"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ApiType = "useMemberPoints";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$Points = intval($_REQUEST["Points"]);
		$OrderID = intval($_REQUEST["OrderID"]);
		
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) > 0)
		{
			$order = $config[DAOIMPL]->getOrder($OrderID);
			if(count($order) > 0)
			{
				if($order["UserID"] == $member["id"])
				{
					if($member["Points"] >= $Points)
					{
						$Result = 0;
						$ErrDescription = "积分使用成功";
						
						$config[DAOIMPL]->updateMember($member["id"], array("Points"=>($member["Points"]-$Points)));
						$config[DAOIMPL]->addPointsHistory(array("Type"=>5, "UserID"=>$member["id"], "OrderID"=>$order["id"], "PrePoints"=>$member["Points"], "CurrentPoints"=>($member["Points"]-$Points), "UpdateTime"=>date("Y-m-d H:i:s", time())));
					}
					else
					{
						$bCheckSuccess = false;
						$Result = -5;
						$ErrDescription = "积分余额不足";
					}
				}
				else
				{
					$bCheckSuccess = false;
					$Result = -4;
					$ErrDescription = "此订单不属于该用户";
				}
			}
			else
			{
				$bCheckSuccess = false;
				$Result = -3;
				$ErrDescription = "无此订单";
			}
		}
		else
		{
			$bCheckSuccess = false;
			$Result = -2;
			$ErrDescription = "无此用户";
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription));
?>