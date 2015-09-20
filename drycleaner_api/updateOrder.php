<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;

	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["ID"]) ||
	   !isset($_REQUEST["Fields"]) ||
	   !isset($_REQUEST["Values"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "updateOrder";

	if($bCheckSuccess)
	{
		
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$OrderId = intval($_REQUEST["ID"]);
		$Fields = intval($_REQUEST["Fields"]);
		$Values = $_REQUEST["Values"];
		$arr_Values = explode("|||", $Values);
		
		$i = 0;
		$arr_udpate_order = array("CreateTime"=>date('Y-m-d H:i:s',time()));
		if($Fields & 0x0001)
		{
			$arr_clothing_id = explode("||", $arr_Values[$i]);
			$arr_udpate_order = $arr_udpate_order + array("ClothingGoodsID"=>$arr_Values[$i]);
			$i++;
		}
		if($Fields & 0x0002)
		{
			$arr_clothing_count = explode("||", $arr_Values[$i]);
			$arr_udpate_order = $arr_udpate_order + array("OrderCount"=>$arr_Values[$i]);
			$i++;
		}
		if($Fields & 0x0004)
		{
			$arr_udpate_order = $arr_udpate_order + array("TotalAmount"=>$arr_Values[$i++]);
		}
		if($Fields & 0x0008)
		{
			$arr_udpate_order = $arr_udpate_order + array("PointsDeduction"=>$arr_Values[$i++]);
		}
		if($Fields & 0x0010)
		{
			$arr_udpate_order = $arr_udpate_order + array("CouponDeduction"=>$arr_Values[$i++]);
		}
		if($Fields & 0x0020)
		{
			$arr_udpate_order = $arr_udpate_order + array("PayAmount"=>$arr_Values[$i++]);
		}
		if($Fields & 0x0040)
		{
			$arr_udpate_order = $arr_udpate_order + array("Status"=>$arr_Values[$i++]);
		}
		
		$config[DAOIMPL]->updateOrder($OrderId, $arr_udpate_order);
		$config[DAOIMPL]->deleteOrderClothingEx($OrderId);
		for($i = 0; $i < count($arr_clothing_id); $i++)
		{
			$config[DAOIMPL]->addOrderClothing(array("OrderID"=>$OrderId,"ClothingGoodsID"=>$arr_clothing_id[$i],"OrderCount"=>$arr_clothing_count[$i]));
		}
		
		$Result = 0;
		$ErrDescription = "更新会员订单成功";
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID, "Fields"=>$Fields, "Values"=>$Values));
?>