<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["Title"]) ||
	   !isset($_REQUEST["Content"]) ||
	   !isset($_REQUEST["Contact"]) ||
	   !isset($_REQUEST["UserName"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "sendSuggestion";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$Title = $_REQUEST["Title"];
		$Content = $_REQUEST["Content"];
		$Contact = $_REQUEST["Contact"];
		$UserName = $_REQUEST["UserName"];
		
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$config[DAOIMPL]->addSuggestion(array("UserID"=>$member["id"], "Title"=>$Title, "Content"=>$Content, "Contact"=>$Contact, "UserName"=>$UserName, "SuggestionTime"=>date("Y-m-d H:i:s", time())));
			$Result = 0;
			$ErrDescription = "发送反馈信息成功";
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription));
?>