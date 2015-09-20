<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	
	if((!isset($_REQUEST["Channel"]) || $_REQUEST["Channel"] == "") ||
	   (!isset($_REQUEST["Account"]) || $_REQUEST["Account"] == "") ||
	   (!isset($_REQUEST["openid"]) || $_REQUEST["openid"] == "") ||
	   (!isset($_REQUEST["access_token"]) || $_REQUEST["access_token"] == ""))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	if($bCheckSuccess)
	{
		$Channel = intval($_REQUEST["Channel"]);
		$Account = $_REQUEST["Account"];
		$openid = $_REQUEST["openid"];
		$access_token = $_REQUEST["access_token"];
	
		if($Channel != 1 &&
		   $Channel != 2)
		{
			$bCheckSuccess = false;
			$Result = -1;
			$ErrDescription = "参数错误";
		}
		
		if($bCheckSuccess)
		{
			$bCheckSuccess = true;
			$Result = 0;
		
			if($Channel == 1)
			{
				$FromWhere = 3;
				$AccountEx = 'qq_' . $openid;
			}
			else if($Channel == 2)
			{
				$FromWhere = 4;
				$AccountEx = 'weibo_' . $openid;
			}
			
			$now_time = date('Y-m-d H:i:s',time());
		
			if(!$config[DAOIMPL]->thirdPartyAccountIsExist($Channel, $openid))
			{
				$Password = sprintf("%d" , rand(100000,999999));
				if($Channel == 1)
				{
					$config[DAOIMPL]->addMember(array("FromWhere"=>$FromWhere, "UserName"=>$AccountEx, "RegisterTime"=>$now_time, "LoginPassword"=>generateUserPassword($Password), "qq_account"=>$Account, "qq_openid"=>$openid));
				}
				else if($Channel == 2)
				{
					$config[DAOIMPL]->addMember(array("FromWhere"=>$FromWhere, "UserName"=>$AccountEx, "RegisterTime"=>$now_time, "LoginPassword"=>generateUserPassword($Password), "weibo_account"=>$Account, "weibo_openid"=>$openid));
				}
				
				$UserID = $config[DAOIMPL]->getLastID("users");
				$bFirstLogin = true;
			}
			else
			{
				$member = $config[DAOIMPL]->getMemberByThirdPartyAccount($Channel, $openid);
				$UserID = $member["id"];
				$bFirstLogin = false;
			}
			$config[DAOIMPL]->updateMember($UserID, array("LastLoginTime"=>$now_time));
			$Token = session_id();
		}
	}
	
	// output
	$ApiType = "LoginWithThirdParty";
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "FirstLogin"=>$bFirstLogin, "Token"=>$Token, "UserID"=>$UserID, "Account"=>$AccountEx, "Password"=>$Password));
?>