<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$ApiType = "getAdDetail";
	$bCheckSuccess = true;

	if(!isset($_REQUEST["ID"]) || $_REQUEST["ID"] == "")
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	if($bCheckSuccess)
	{
		$event = $config[DAOIMPL]->getEvent(intval($_REQUEST["ID"]));
		if(count($event) > 0)
		{
			$bCheckSuccess = false;
			$Result = 0;
			$ErrDescription = "获取成功";
			$Title = $event["Title"];
			$PicFileName = $event["PicFileName"];
			$Content = $event["Content"];
			$StartTime = $event["StartTime"];
			$EndTime = $event["EndTime"];
			$JoinedMemberCount = intval($event["JoinedMemberCount"]);
		}
		else
		{
			$bCheckSuccess = false;
			$Result = -2;
			$ErrDescription = "无此ID号的活动";
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Title"=>$Title, "PicUrl"=>$PicFileName, "Content"=>$Content, "StartTime"=>$StartTime, "EndTime"=>$EndTime, "JoinedMemberCount"=>$JoinedMemberCount));
?>