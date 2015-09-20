<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '修改时间段信息成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$timeperiod = $config[DAOIMPL]->getTimeperiod($_REQUEST["id"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	
	$title = '';
	$describe = '';
	if(!isset($_POST["title"]) || $_POST["title"] == '')
	{
		$errorMsg = $errorMsg . "时间段不允许为空!<br>";
	}
	else
	{
		$title = $_POST["title"];
	}
	if($errorMsg == '')
	{
		$config[DAOIMPL]->updateTimeperiod($_POST["id"], array("title"=>$title));
		$timeperiod = $config[DAOIMPL]->getTimeperiod($_POST["id"]);
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="timeperiod.php">时间段描述管理</a> -> 编辑时间段描述
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑时间段</h3>
    </div>
    <div class="bd">
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if($errorMsg == '')
		{
?>
			<p class="blue"><?php echo $successMsg; ?></p>
<?php
		}
		else
		{
?>
			<p class="red"><?php echo $errorMsg; ?></p>
<?php
		}
	}
?>
		<div class="commonform">
		    <form action="?" method="POST" enctype="multipart/form-data">
		        <fieldset class="radius5">
					<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">
		            <div class="item">
		                <label>时间段</label><input class="txt" type="text" name="title" value="<?php echo $timeperiod["title"];?>">
		            </div>
		            <div class="item">
		                <label></label><input type="submit" value="修 改">
		            </div>
				</fieldset>
		    </form>
		</div>
        <p>&nbsp;</p>
	</div>
</div>