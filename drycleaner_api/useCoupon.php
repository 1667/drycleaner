<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["ID"]) ||
	   !isset($_REQUEST["OrderID"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ApiType = "useCoupon";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$ID = intval($_REQUEST["ID"]);
		$OrderID = intval($_REQUEST["OrderID"]);
		
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) > 0)
		{
			$coupon = $config[DAOIMPL]->getCoupon($ID);
			if(count($coupon) > 0)
			{
				if($coupon["UserID"] == $member["id"])
				{
					$order = $config[DAOIMPL]->getOrder($OrderID);
					if(count($order) > 0)
					{
						if($order["UserID"] == $member["id"])
						{
							if($coupon["Status"] == 0)
							{
								$Result = 0;
								$ErrDescription = "使用优惠券成功";
								
								$config[DAOIMPL]->updateCoupon($ID, array("Status"=>1,"UseTime"=>date("Y-m-d H:i:s", time()),"OrderID"=>$OrderID));
							}
							else
							{
								$bCheckSuccess = false;
								$Result = -5;
								$ErrDescription = "此优惠券已使用";
							}
						}
						else
						{
							$bCheckSuccess = false;
							$Result = -7;
							$ErrDescription = "此订单不属于该用户";
						}
					}
					else
					{
						$bCheckSuccess = false;
						$Result = -6;
						$ErrDescription = "无此订单";
					}
				}
				else
				{
					$bCheckSuccess = false;
					$Result = -4;
					$ErrDescription = "此优惠券不属于该用户";
				}
			}
			else
			{
				$bCheckSuccess = false;
				$Result = -3;
				$ErrDescription = "无此优惠券";
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