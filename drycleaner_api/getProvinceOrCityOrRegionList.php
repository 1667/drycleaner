<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Type"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	else
	{
		$Type = intval($_REQUEST["Type"]);
		if(($Type == 2 || $Type == 3) &&
		   !isset($_REQUEST["ParentCode"]))
		{
			$bCheckSuccess = false;
			$Result = -1;
			$ErrDescription = "参数错误";
		}
	}

	$ApiType = "getProvinceOrCityOrRegionList";

	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "获取成功";
		
		$Type = intval($_REQUEST["Type"]);
		$ParentCode = $_REQUEST["ParentCode"];
		
		if($Type == 1)
		{
			$Count = $config[DAOIMPL]->getProvinceCount();
			$province_rs = $config[DAOIMPL]->getProvinces();
			for($i = 0 ; $i < $Count ; $i++)
			{
				$province_arr = mysql_fetch_array($province_rs);
				$list_array[] = array("code"=>$province_arr["code"], "name"=>$province_arr["name"]);
			}
		}
		else if($Type == 2)
		{
			$Count = $config[DAOIMPL]->getCityCount($ParentCode);
			$city_rs = $config[DAOIMPL]->getCitys($ParentCode);
			for($i = 0 ; $i < $Count ; $i++)
			{
				$city_arr = mysql_fetch_array($city_rs);
				$list_array[] = array("code"=>$city_arr["code"], "name"=>$city_arr["name"]);
			}
		}
		else if($Type == 3)
		{
			$Count = $config[DAOIMPL]->getRegionCount($ParentCode);
			$region_rs = $config[DAOIMPL]->getRegions($ParentCode);
			for($i = 0 ; $i < $Count ; $i++)
			{
				$region_arr = mysql_fetch_array($region_rs);
				$list_array[] = array("code"=>$region_arr["code"], "name"=>$region_arr["name"]);
			}
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $list_array));
?>