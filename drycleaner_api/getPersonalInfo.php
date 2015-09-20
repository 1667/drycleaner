<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["Fields"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ApiType = "getPersonalInfo";
	
	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$Fields = intval($_REQUEST["Fields"]);
		
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$Result = 0;
			$ErrDescription = "获取个人信息成功";
			$value_count = 0;
			
			if($Fields & 0x00000001)
			{
				$info_array[$value_count++] = array("Value"=>$member["UserName"]);
			}
			if($Fields & 0x00000002)
			{
				$info_array[$value_count++] = array("Value"=>$member["Sex"]);
			}
			if($Fields & 0x00000004)
			{
				$info_array[$value_count++] = array("Value"=>$member["PhoneNumber"]);
			}
			if($Fields & 0x00000008)
			{
				$info_array[$value_count++] = array("Value"=>$member["Email"]);
			}
			if($Fields & 0x00000010)
			{
				$info_array[$value_count++] = array("Value"=>$member["TrueName"]);
			}
			if($Fields & 0x00000020)
			{
				$info_array[$value_count++] = array("Value"=>$member["IdentifyNumber"]);
			}
			if($Fields & 0x00000040)
			{
				$info_array[$value_count++] = array("Value"=>$member["Address"]);
			}
			if($Fields & 0x00000080)
			{
				$info_array[$value_count++] = array("Value"=>$member["Birthday"]);
			}
			if($Fields & 0x00000100)
			{
				$info_array[$value_count++] = array("Value"=>$member["MarryState"]);
			}
			if($Fields & 0x00000200)
			{
				$info_array[$value_count++] = array("Value"=>$member["MonthIncome"]);
			}
			if($Fields & 0x00000400)
			{
				$info_array[$value_count++] = array("Value"=>$member["Hobbies"]);
			}
			if($Fields & 0x00000800)
			{
				$info_array[$value_count++] = array("Value"=>$member["EmailStatus"]);
			}
			if($Fields & 0x00001000)
			{
				$info_array[$value_count++] = array("Value"=>$member["PhoneStatus"]);
			}
			if($Fields & 0x00002000)
			{
				$info_array[$value_count++] = array("Value"=>$member["Province"]);
			}
			if($Fields & 0x00004000)
			{
				$info_array[$value_count++] = array("Value"=>$member["City"]);
			}
			if($Fields & 0x00008000)
			{
				$info_array[$value_count++] = array("Value"=>$member["Region"]);
			}
			if($Fields & 0x00010000)
			{
				$info_array[$value_count++] = array("Value"=>$member["RegisterTime"]);
			}
			if($Fields & 0x00020000)
			{
				$info_array[$value_count++] = array("Value"=>$member["LastLoginTime"]);
			}
			if($Fields & 0x00040000)
			{
				$info_array[$value_count++] = array("Value"=>$member["FromWhere"]);
			}
			if($Fields & 0x00080000)
			{
				$info_array[$value_count++] = array("Value"=>$member["Amount"]);
			}
			if($Fields & 0x00100000)
			{
				$info_array[$value_count++] = array("Value"=>$member["Points"]);
			}
			if($Fields & 0x00200000)
			{
				$info_array[$value_count++] = array("Value"=>$member["PreTel"]);
			}
			if($Fields & 0x00400000)
			{
				$info_array[$value_count++] = array("Value"=>$member["Tel"]);
			}
			if($Fields & 0x00800000)
			{
				$info_array[$value_count++] = array("Value"=>$member["LaterTel"]);
			}
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Fields"=>$Fields, $info_array));
?>