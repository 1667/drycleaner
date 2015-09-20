<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	
	if((!isset($_REQUEST["Account"]) || $_REQUEST["Account"] == "") ||
	   (!isset($_REQUEST["Password"]) || $_REQUEST["Password"] == "") ||
	   (strlen($_REQUEST["Password"]) < 6))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$Account = $_REQUEST["Account"];
	$Password = $_REQUEST["Password"];
	
	if($bCheckSuccess)
	{
		if(!$config[DAOIMPL]->memberUserNameIsExist($Account))
		{
			$bCheckSuccess = false;
			$Result = -2;
	        $ErrDescription = '账户不存在！';
		}
		else
		{
		    $member = $config[DAOIMPL]->getMemberByName($Account);
			
		    if(isset($member['LoginPassword']) && 
			   ($member['LoginPassword'] == generateUserPassword($Password)))
			{
				$Result = 0;
				$ErrDescription = "登录成功";
				$Token = $config[DAOIMPL]->generateToken();
				$LoginedTime = date('Y-m-d H:i:s',time());
				$UserID = $member["id"];
				$config[DAOIMPL]->updateMember($UserID, array("LastLoginTime"=>$LoginedTime));
		    }
			else
			{
				$bCheckSuccess = false;
				$Result = -3;
		        $ErrDescription = '密码错误';
		    }
		}   
	}
	
	// output
	$ApiType = "login";
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Token"=>$Token, "UserID"=>$UserID, "Account"=>$Account));
?>