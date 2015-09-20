<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$ApiType = "getEventsSummary";
	$Result = 0;
	$ErrDescription = "获取成功";

	$Count = $config[DAOIMPL]->getEventCount();
	$events = $config[DAOIMPL]->getEvents(1,-1);

	for($i = 0 ; $i < $Count ; $i++)
	{
		$event = mysql_fetch_array($events);
		$event_array[$i] = array("ID"=>$event["id"]);
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "Count"=>$Count, $event_array));
?>