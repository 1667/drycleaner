<?php
	$ApiType = "requestOrderSerial";
	$Result = 0;
	$ErrDescription = "申请订单编号成功";
	$OrderSerial = sprintf("%d%d", time(), rand(10000,99999));
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "OrderSerial"=>$OrderSerial));
?>