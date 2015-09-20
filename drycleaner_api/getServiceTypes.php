<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;

	if(!isset($_REQUEST["ParentTypeID"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	$ApiType = "getServiceTypes";
	
	if($bCheckSuccess)
	{
		$ParentTypeID = $_REQUEST["ParentTypeID"];
		$Result = 0;
		$ErrDescription = "获取成功";
		$Count = $config[DAOIMPL]->getServiceTypeCountEx($ParentTypeID);
		$servicetypes_rs = $config[DAOIMPL]->getServiceTypesEx(1,-1,$ParentTypeID);
		for($i = 0 ; $i < $Count ; $i++)
		{
			$row = mysql_fetch_array($servicetypes_rs);
			$servicetypes_array[$i] = array("ID"=>$row["id"], "Title"=>$row["TypeName"], "PicUrl"=>$row["PicFileName"]);
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $servicetypes_array));
?>