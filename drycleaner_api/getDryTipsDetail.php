<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	
	if(!isset($_REQUEST["ID"]) ||
		$_REQUEST["ID"] <=0 )
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ApiType = "getDryTipsDetail";
	
	if($bCheckSuccess)
	{
		$TipsID = $_REQUEST["ID"];
		
		$arr_rs = $config[DAOIMPL]->getDryTip($TipsID);
		
		if(count($arr_rs) > 0)
		{
			$Result = 0;
			$ErrDescription = "获取成功";
			$Title = $arr_rs["Title"];
			$PicUrl = $arr_rs["PicFileName"];
			$Content = $arr_rs["Content"];
		}
		else
		{
			$Result = -2;
			$ErrDescription = "无此ID号的干洗小贴士";
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$TipsID, "Title"=>$Title, "PicUrl"=>$PicUrl, "Content"=>$Content));
?>