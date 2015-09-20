<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["Type"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "getOrders";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$Type = intval($_REQUEST["Type"]);

		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$Result = 0;
			$ErrDescription = "获取会员订单成功";
			$Count = $config[DAOIMPL]->getOrderCount($Type, $member["id"]);
			$order_rs = $config[DAOIMPL]->getOrders($Type, 1,-1,$member["id"]);
			for($i = 0 ; $i < $Count ; $i++)
			{
				$row = mysql_fetch_array($order_rs);
				
				$order_clothing_count = $config[DAOIMPL]->getOrderClothingCount($row['id']);
				$order_clothings_arr = $config[DAOIMPL]->getOrderClothings(1,-1,$row['id']);
				$order_clothing_ids = array();
				$order_clothing_counts = array();
				$order_clothing_names = array();
				for($j = 0 ; $j < $order_clothing_count ; $j++)
				{
					$order_clothing = mysql_fetch_array($order_clothings_arr);
					$order_clothing_ids[] = $order_clothing["ClothingGoodsID"];
					$order_clothing_counts[] = $order_clothing["OrderCount"];
					$row_goods = $config[DAOIMPL]->getGoods($order_clothing["ClothingGoodsID"]);
					$order_clothing_names[] = $row_goods['GoodsName'];
				}
				$ClothingCounts = "";
				$ClothingIds = "";
				for($j = 0 ; $j < $order_clothing_count ; $j++)
				{
					if($j != 0)
					{
						$ClothingCounts = $ClothingCounts . "||";
						$ClothingIds = $ClothingIds . "||";
					}
					$ClothingCounts = $ClothingCounts . $order_clothing_counts[$j];
					$ClothingIds = $ClothingIds . $order_clothing_ids[$j];
				}
				
				$orders_array[$i] = array("OrderType"=>$Type, "ID"=>$row["id"],"UserID"=>$row["UserID"],"Serial"=>$row["OrderSerial"], "CreateTime"=>$row["CreateTime"], "OrderTime"=>$row["OrderTime"],"ExpiredTime"=>"2014-10-09 10:00:00","RemainTime"=>"12时18分16秒","ClothingCount"=>$ClothingCounts,"ClothingGoodsID"=>$ClothingIds,"TotalAmount"=>$row["TotalAmount"],"PointsDeduction"=>$row["PointsDeduction"],"CouponDeduction"=>$row["CouponDeduction"],"PayAmount"=>$row["PayAmount"],"Status"=>$row["Status"],"PayWay"=>$row["PayWay"],"AddressID"=>$row["AddressId"],"GetType"=>$row["GetType"],"GetTimePeriod"=>$row["GetTimePeriod"],"Memo"=>$row["Memo"]);
			}
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $orders_array));
?>