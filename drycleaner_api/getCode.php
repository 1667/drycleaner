<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";
	
	$bCheckSuccess = true;
	
	// input
	if((!isset($_REQUEST["PhoneNumber"]) || $_REQUEST["PhoneNumber"] == "") ||
	   (!isset($_REQUEST["Type"]) || $_REQUEST["Type"] == ""))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$PhoneNumber = $_REQUEST["PhoneNumber"];
	$Type = intval($_REQUEST["Type"]);
	
	if($Type != 1 && $Type != 2)
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	if($bCheckSuccess)
	{
		$Code = sprintf("%d" , rand(1000,9999));
		
		$Token = $config[DAOIMPL]->generateToken();
		
		if($config[DAOIMPL]->sendSms($PhoneNumber, $Code))
		{
			$Result = 0;
			$ErrDescription = "发送验证码成功";
			$config[DAOIMPL]->addCodeToken(array("Type"=>$Type, "Code"=>$Code, "Token"=>$Token, "CreateTime"=>date('Y-m-d H:i:s',time())));
		}
		else
		{
			$Result = -2;
			$ErrDescription = "发送验证码失败";
		}
	}
	
	$ApiType = "getCode";
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Code"=>$Code , "Token"=>$Token));
?>