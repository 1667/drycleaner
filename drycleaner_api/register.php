<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";
	
	// input
	$bCheckSuccess = true;
	
	if((!isset($_REQUEST["FromWhere"]) || $_REQUEST["FromWhere"] == "") ||
	   (!isset($_REQUEST["Account"]) || $_REQUEST["Account"] == "") ||
	   (!isset($_REQUEST["AccountType"]) || $_REQUEST["AccountType"] == "") ||
	   (intval($_REQUEST["FromWhere"]) != 1 && intval($_REQUEST["FromWhere"]) != 2) ||
	   (intval($_REQUEST["AccountType"]) != 1 && intval($_REQUEST["AccountType"]) != 2 && intval($_REQUEST["AccountType"]) != 3))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	if(intval($_REQUEST["FromWhere"]) == 1 &&
	   (!isset($_REQUEST["Password"]) || strlen($_REQUEST["Password"]) < 6))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$FromWhere = $_REQUEST["FromWhere"];
	$Account = $_REQUEST["Account"];
	$AccountType = $_REQUEST["AccountType"];
	$Password = $_REQUEST["Password"];
	
	if($bCheckSuccess)
	{
		if($config[DAOIMPL]->memberUserNameIsExist($Account))
		{
			$bCheckSuccess = false;
			$Result = -2;
			$ErrDescription = "账号已经存在";
		}
	}

	if($bCheckSuccess)
	{
		if($AccountType == 2)
			$PhoneStatus = 1;
		else
			$PhoneStatus = 0;
		
		if($AccountType == 1)
		{
			$config[DAOIMPL]->addMember(array("FromWhere"=>$FromWhere, "UserName"=>$Account, "RegisterTime"=>date('Y-m-d H:i:s',time()), "LoginPassword"=>generateUserPassword($Password), "PhoneStatus"=>$PhoneStatus));
		}
		else if($AccountType == 2)
		{
			$Password = sprintf("%d" , rand(100000,999999));
			$config[DAOIMPL]->addMember(array("FromWhere"=>$FromWhere, "UserName"=>$Account, "RegisterTime"=>date('Y-m-d H:i:s',time()), "LoginPassword"=>generateUserPassword($Password), "PhoneNumber"=>$Account, "PhoneStatus"=>$PhoneStatus));
			$config[DAOIMPL]->sendSms($Account, $Password);
		}
		else if($AccountType == 3)
		{
			$config[DAOIMPL]->addMember(array("FromWhere"=>$FromWhere, "UserName"=>$Account, "RegisterTime"=>date('Y-m-d H:i:s',time()), "LoginPassword"=>generateUserPassword($Password), "Email"=>$Account, "PhoneStatus"=>$PhoneStatus));
		}
		
		$Result = 0;
		$ErrDescription = "注册成功";
	}
	
	// output
	$ApiType = "register";

	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription));
?>