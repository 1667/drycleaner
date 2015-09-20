<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '添加时间段成功';
$errorMsg = '';

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
		$config[DAOIMPL]->addTimeperiod(array("title"=>$title));
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="timeperiod.php">时间段管理</a> -> 添加时间段
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>添加时间段</h3>
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
		            <div class="item">
		                <label>时间段</label>
		                <input class="txt" type="text" name="title" value="">
		            </div>
		            <div class="item">
						<label></label>
		                <input type="submit" value="添 加">
		            </div>
				</fieldset>
		    </form>
		</div>
        <p>&nbsp;</p>
	</div>
</div>