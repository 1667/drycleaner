<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["Fields"]) ||
	   !isset($_REQUEST["Values"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "updatePersonalInfo";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$Fields = intval($_REQUEST["Fields"]);
		$Values = $_REQUEST["Values"];
	
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$Result = 0;
			$ErrDescription = "更新个人信息成功";
			$value_index = 0;
			$arr_values = explode("||", $Values);
			if($Fields & 0x0001)
			{
				$update_member["UserName"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0002)
			{
				$update_member["Sex"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0004)
			{
				$update_member["PhoneNumber"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0008)
			{
				$update_member["Email"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0010)
			{
				$update_member["TrueName"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0020)
			{
				$update_member["IdentifyNumber"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0040)
			{
				$update_member["Address"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0080)
			{
				$update_member["Birthday"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0100)
			{
				$update_member["MarryState"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0200)
			{
				$update_member["MonthIncome"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0400)
			{
				$update_member["Hobbies"] = $arr_values[$value_index++];
			}
			if($Fields & 0x0800)
			{
				$update_member["EmailStatus"] = $arr_values[$value_index++];
			}
			if($Fields & 0x1000)
			{
				$update_member["PhoneStatus"] = $arr_values[$value_index++];
			}
			if($Fields & 0x2000)
			{
				$update_member["Province"] = $arr_values[$value_index++];
			}
			if($Fields & 0x4000)
			{
				$update_member["City"] = $arr_values[$value_index++];
			}
			if($Fields & 0x8000)
			{
				$update_member["Region"] = $arr_values[$value_index++];
			}
			$config[DAOIMPL]->updateMember($member["id"], $update_member);
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription));
?>