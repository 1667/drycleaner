<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	// input
	$bCheckSuccess = true;

	if((!isset($_REQUEST["Account"]) || $_REQUEST["Account"] == "") ||
	   (!isset($_REQUEST["Token"]) || $_REQUEST["Token"] == ""))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	// output
	$ApiType = "getAddressSummary";

	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "获取成功";
	
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
	
		if(!$config[DAOIMPL]->memberUserNameIsExist($Account))
		{
			$bCheckSuccess = false;
			$Result = -2;
	        $ErrDescription = '账户不存在！';
		}
		else
		{
		    $member = $config[DAOIMPL]->getMemberByName($Account);
			$Count = $config[DAOIMPL]->getAddressCount($member["id"]);
			$addresses = $config[DAOIMPL]->getAddresses($member["id"],1,-1);

			for($i = 0 ; $i < $Count ; $i++)
			{
				$address = mysql_fetch_array($addresses);
				$address_array[$i] = array("ID"=>$address["id"]);
			}
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $address_array));
?>