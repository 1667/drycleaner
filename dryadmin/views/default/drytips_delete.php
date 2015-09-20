<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$is_batch_delete = '0';

if(isset($_REQUEST["batch"]) && isset($_REQUEST["batch"]) != '')
{
	$is_batch_delete = $_REQUEST["batch"];
}

if(intval($is_batch_delete))
{
	if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
	{
		echo '缺乏参数';
		exit();
	}
	$arr = explode(",",$_REQUEST["id"]);
	for($i = 0 ; $i < count($arr); $i++)
	{
		$config[DAOIMPL]->deleteDryTip($arr[$i]);
	}
}
else
{
	if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '' ||
	   !isset($_REQUEST["page"]) || $_REQUEST["page"] == '' ||
	   !isset($_REQUEST["number_per_page"]) || $_REQUEST["number_per_page"] == '')
	{
		echo '缺乏参数';
		exit();
	}
	$config[DAOIMPL]->deleteDryTip($_REQUEST["id"]);
}

echo "<SCRIPT LANGUAGE='JavaScript'>";
if(intval($is_batch_delete))
{
	echo "window.location='" . $config[ADMINBASEURL] . "drytips.php'"; 
}
else
{
	echo "window.location='" . $config[ADMINBASEURL] . "drytips.php?page=" . $_REQUEST["page"] . "&number_per_page=" . $_REQUEST["number_per_page"] . "'"; 
} 
echo "</SCRIPT>";

?>