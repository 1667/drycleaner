<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["Status"]) ||
	   (intval($_REQUEST["Status"]) != 0 && intval($_REQUEST["Status"]) != 1 && intval($_REQUEST["Status"]) != 2))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "getMemberCoupons";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$Status = intval($_REQUEST["Status"]);
	
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$Result = 0;
			$ErrDescription = "获取会员优惠券成功";
			$Count = $config[DAOIMPL]->getCouponCount($member["id"], $Status);
			$coupon_rs = $config[DAOIMPL]->getCoupons(1,-1,$member["id"], $Status);
			for($i = 0 ; $i < $Count ; $i++)
			{
				$row = mysql_fetch_array($coupon_rs);
				$coupons_array[$i] = array("ID"=>$row["id"], "Value"=>$row["FaceValue"], "Code"=>$row["Code"], "GainTime"=>$row["GainTime"], "UseTime"=>$row["UseTime"], "Status"=>$row["Status"]);
			}
		}	
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $coupons_array));
?>