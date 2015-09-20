<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;

	if((!isset($_REQUEST["Account"]) || $_REQUEST["Account"] == "") ||
	   (!isset($_REQUEST["Token"]) || $_REQUEST["Token"] == "") ||
	   (!isset($_REQUEST["Type"]) || ($_REQUEST["Type"] != "1" && $_REQUEST["Type"] != "2" && $_REQUEST["Type"] != "3")) ||
	   (!isset($_REQUEST["NewPassword"]) || $_REQUEST["NewPassword"] == "") ||
	   (strlen($_REQUEST["NewPassword"]) < 6))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$Account = $_REQUEST["Account"];
	$Token = $_REQUEST["Token"];
	$Type = intval($_REQUEST["Type"]);
	$NewPassword = $_REQUEST["NewPassword"];
	
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
			
			$config[DAOIMPL]->updateMemberPassword($member['id'], $Type, generateUserPassword($NewPassword));
			
			/*
			if($Type == 1)
			{
			    if(isset($member['LoginPassword']) && 
				   ($member['LoginPassword'] == generateUserPassword($OldPassword)))
				{
					$config[DAOIMPL]->updateMemberPassword($member['id'], $Type, generateUserPassword($NewPassword));
				}
				else
				{
					$bCheckSuccess = false;
					$Result = -3;
			        $ErrDescription = '密码错误！';
				}
				$config[DAOIMPL]->updateMemberPassword($member['id'], $Type, generateUserPassword($NewPassword));
			}
		    else if($Type == 2)
			{
				if(($member['PayPassword'] == '' &&
				    $OldPassword == '') ||
			       ($member['PayPassword'] == generateUserPassword($OldPassword)))
				{
					$config[DAOIMPL]->updateMemberPassword($member['id'], $Type, generateUserPassword($NewPassword));
				}
				else
				{
					$bCheckSuccess = false;
					$Result = -3;
			        $ErrDescription = '密码错误！';
				}
			}
		    else if($Type == 3)
			{
				$config[DAOIMPL]->updateMemberPassword($member['id'], $Type, generateUserPassword($NewPassword));
			}
			*/
		}
	}
	
	// output
	$ApiType = "updatePassword";
	
	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "更新密码成功";
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription));
?>