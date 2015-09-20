<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	// input
	$bCheckSuccess = true;
	
	if((!isset($_REQUEST["Account"]) || $_REQUEST["Account"] == "") ||
	   (!isset($_REQUEST["Token"]) || $_REQUEST["Token"] == "") ||
	   (!isset($_REQUEST["ID"]) || $_REQUEST["ID"] == ""))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	// output
	$ApiType = "deleteAddress";
	
	// input
	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "删除收货地址成功";
		
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$ID = $_REQUEST["ID"];
		
		if(!$config[DAOIMPL]->memberUserNameIsExist($Account))
		{
			$bCheckSuccess = false;
			$Result = -2;
	        $ErrDescription = '账户不存在！';
		}
		else
		{
		    $member = $config[DAOIMPL]->getMemberByName($Account);
			
			$config[DAOIMPL]->deleteAddress($member["id"], $ID);
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>