<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	
	if(!isset($_REQUEST["ID"]) ||
		$_REQUEST["ID"] <=0 )
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	// output
	$ApiType = "getClothingGoodsDetail";
	$ServiceTypeID = 1;
	$Name = "西服";
	$PicUrl = "1.jpg";
	$ServiceMode = 0x003F;
	$CurrentPrice = 40;
	$SourcePrice = 80;
	$ExpiredTime = 100000;
	$WrapMode = "PVC";
	$DistributionMode = "威能快递";
	$DryDescription = "西服介绍";
	$MaterialQuality = 0x0001;
	$Style = 0x0001;
	
	if($bCheckSuccess)
	{
		$ID = $_REQUEST["ID"];
		$arr_rs = $config[DAOIMPL]->getGoods($ID);
		
		if(count($arr_rs) > 0)
		{
			$Result = 0;
			$ErrDescription = "获取衣物详情成功";
			
			$ServiceType = $config[DAOIMPL]->getServiceType($arr_rs["ServiceTypeID"]);
			$MainServiceTypeID = $ServiceType["ParentID"];
			$ServiceTypeID = $arr_rs["ServiceTypeID"];
			$Name = $arr_rs["GoodsName"];
			$PicUrl = $arr_rs["PicFileName"];
			$ServiceMode = $arr_rs["ServiceMode"];
			$CurrentPrice = $arr_rs["CurrentPrice"];
			$SourcePrice = $arr_rs["SourcePrice"];
			$ExpiredTime = $arr_rs["ExpiredTime"];
			$WrapMode = $arr_rs["WrapMode"];
			$DistributionMode = $arr_rs["DistributionMode"];
			$DryDescription = $arr_rs["DryDescription"];
			$MaterialQuality = $arr_rs["MaterialQuality"];
			$Style = $arr_rs["Style"];
		}
		else
		{
			$Result = -2;
			$ErrDescription = "无此ID号的衣物";
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription,"ID"=>$ID, "MainServiceTypeID"=>$MainServiceTypeID,"ServiceTypeID"=>$ServiceTypeID, "Name"=>$Name, "PicUrl"=>$PicFileName, "ServiceMode"=>$ServiceMode, "CurrentPrice"=>$CurrentPrice, "SourcePrice"=>$SourcePrice, "ExpiredTime"=>$ExpiredTime, "WrapMode"=>$WrapMode, "DistributionMode"=>$DistributionMode, "MaterialQuality"=>$MaterialQuality, "Style"=>$Style, "DryDescription"=>$DryDescription));
?>