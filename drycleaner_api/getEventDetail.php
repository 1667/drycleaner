<?php
	require_once("../common/MySQLClass.php");
	
	$db = new MySQLClass();
	
	// input
	$Account = $_REQUEST["Account"];
	$Token = $_REQUEST["Token"];
	$ID = $_REQUEST["ID"];
	
	// output
	$ApiType = "getMemberCoupons";
	$Result = 0;
	$ErrDescription = "获取会员优惠券成功";
	$Title = "Title";
	$PicUrl = "2.jpg";
	$Description = "详细介绍";
	$StartTime = "2014-09-12 12:00:00";
	$EndTime = "2014-09-13 12:00:00";
	$JoinedNumber = 18;
	
	$db->close();
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID, "Title"=>$Title, "PicUrl"=>$PicUrl, "Description"=>$Description, "StartTime"=>$StartTime, "EndTime"=>$EndTime, "JoinedNumber"=>$JoinedNumber));
?>