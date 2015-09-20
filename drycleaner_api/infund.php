<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";
	
	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["Amount"]) ||
	   !isset($_REQUEST["InfundChannel"]) ||
	   !isset($_REQUEST["ThirdPartyAccount"]) ||
	   !isset($_REQUEST["ThirdPartySerial"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "infund";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$Amount = floatval($_REQUEST["Amount"]);
		$Channel = intval($_REQUEST["InfundChannel"]);
		$ThirdPartyAccount = $_REQUEST["ThirdPartyAccount"];
		$ThirdPartySerial = $_REQUEST["ThirdPartySerial"];
		$InfundTime = date("Y-m-d H:i:s", time());
		
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$config[DAOIMPL]->updateMember($member["id"], array("Amount"=>($member["Amount"] + floatval($_REQUEST["Amount"]))));
			$config[DAOIMPL]->addInfundHistory(array("UserID"=>$member["id"], "Channel"=>$Channel, "Account"=>$ThirdPartyAccount, "Amount"=>$Amount, "Serial"=>$ThirdPartySerial, "InfundTime"=>$InfundTime));
			$config[DAOIMPL]->addAccountAmountHistory(array("UserID"=>$member["id"], "PreAmount"=>$member["Amount"], "CurrentAmount"=>($member["Amount"] + floatval($_REQUEST["Amount"])), "UpdateTime"=>$InfundTime, "Type"=>1));
			$Result = 0;
			$ErrDescription = "充值成功";
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription));
?>