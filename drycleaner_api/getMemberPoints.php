<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "getMemberPoints";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$Result = 0;
			$ErrDescription = "获取会员积分成功";
			$Points = $member["Points"];
		}
	}

	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Points"=>$Points));
?>