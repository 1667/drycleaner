<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;

	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["ID"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "deleteOrder";

	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "删除会员订单成功";
		
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$ID = intval($_REQUEST["ID"]);
		
		if(!$config[DAOIMPL]->memberUserNameIsExist($Account))
		{
			$bCheckSuccess = false;
			$Result = -2;
	        $ErrDescription = '账户不存在！';
		}
		else
		{
		    $member = $config[DAOIMPL]->getMemberByName($Account);
			$order = $config[DAOIMPL]->getOrder($ID);
			if(count($order) > 0 && isset($order["UserID"]) && ($order["UserID"] == $member["id"]))
			{
				$config[DAOIMPL]->deleteOrder($ID);
				$config[DAOIMPL]->deleteOrderClothingEx($ID);
			}
			else
			{
				$bCheckSuccess = false;
				$Result = -3;
		        $ErrDescription = '无权删除！';
			}
		}
	}

	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>