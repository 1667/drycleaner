<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["OrderType"]) ||
	   !isset($_REQUEST["Serial"]) ||
	   !isset($_REQUEST["ClothingCount"]) ||
	   !isset($_REQUEST["ClothingGoodsID"]) ||
	   !isset($_REQUEST["TotalAmount"]) ||
	   !isset($_REQUEST["PointsDeduction"]) ||
	   !isset($_REQUEST["CouponDeduction"]) ||
	   !isset($_REQUEST["PayAmount"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "addOrder";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$OrderType = intval($_REQUEST["OrderType"]);
		$Serial = $_REQUEST["Serial"];
		$ClothingCount = $_REQUEST["ClothingCount"];
		$ClothingGoodsID = $_REQUEST["ClothingGoodsID"];
		$TotalAmount = floatval($_REQUEST["TotalAmount"]);
		$PointsDeduction = floatval($_REQUEST["PointsDeduction"]);
		$CouponDeduction = floatval($_REQUEST["CouponDeduction"]);
		$PayAmount = floatval($_REQUEST["PayAmount"]);
		$arr_ClothingGoodsID = explode("||", $ClothingGoodsID);
		$arr_ClothingCount = explode("||", $ClothingCount);

		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$now_time = date('Y-m-d H:i:s',time());
			$Result = 0;
			$ErrDescription = "添加会员订单成功";
			$config[DAOIMPL]->addOrder(array("OrderSerial"=>$Serial, 
											 "UserID"=>$member["id"], 
										 	 "ClothingGoodsID"=>$ClothingGoodsID,
											 "OrderCount"=>$ClothingCount,
										 	 "OrderTime"=>$now_time,
										 	 "CreateTime"=>$now_time,
										 	 "TotalAmount"=>$TotalAmount,
										 	 "PointsDeduction"=>$PointsDeduction,
										 	 "CouponDeduction"=>$CouponDeduction,
										 	 "PayAmount"=>$PayAmount,
										 	 "Status"=>$OrderType));
			$ID = $config[DAOIMPL]->getLastID("orders");
			for($i = 0 ; $i < $ClothingCount; $i++)
			{
				$config[DAOIMPL]->addOrderClothing(array("OrderID"=>$ID, "ClothingGoodsID"=>$arr_ClothingGoodsID[$i], "OrderCount"=>$arr_ClothingCount[$i]));
			}
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "OrderType"=>$OrderType, "ID"=>$ID, "Serial"=>$Serial));
?>