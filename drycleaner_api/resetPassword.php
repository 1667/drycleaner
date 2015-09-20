<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;

	if((!isset($_REQUEST["PhoneNumber"]) || $_REQUEST["PhoneNumber"] == "") ||
	   (!isset($_REQUEST["Token"]) || $_REQUEST["Token"] == "") ||
	   (!isset($_REQUEST["Code"]) || $_REQUEST["Code"] == "") ||
	   (!isset($_REQUEST["Password"]) || $_REQUEST["Password"] == "") ||
	   (strlen($_REQUEST["Password"]) < 6))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	if($bCheckSuccess)
	{
		$PhoneNumber = $_REQUEST["PhoneNumber"];
		$Token = $_REQUEST["Token"];
		$Code = $_REQUEST["Code"];
		$Password = $_REQUEST["Password"];
		
		if(!$config[DAOIMPL]->codeTokenIsExist(2, $Code, $Token))
		{
			$bCheckSuccess = false;
			$Result = -2;
	        $ErrDescription = '验证码与令牌不符合！';
		}
		else
		{
			if(!$config[DAOIMPL]->memberUserNameIsExist($PhoneNumber))
			{
				$bCheckSuccess = false;
				$Result = -3;
		        $ErrDescription = '账户不存在！';
			}
			else
			{
			    $member = $config[DAOIMPL]->getMemberByName($PhoneNumber);
				$config[DAOIMPL]->updateMemberPassword($member['id'], 1, generateUserPassword($Password));
				$config[DAOIMPL]->updateCodeTokenEx(2, $Code, $Token , array("Status"=>1));
			}
		}
	}
	
	$ApiType = "resetPassword";
	
	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "重置密码成功";
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription));
?>