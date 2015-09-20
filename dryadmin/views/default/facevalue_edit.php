<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '修改充值方式成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$facevalue = $config[DAOIMPL]->getFacevalue($_REQUEST["id"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$picFileName = '';
	
	if(!isset($_POST["title"]) || $_POST["title"] == '')
	{
		$errorMsg = $errorMsg . "充值方式不允许为空!<br>";
	}
	else
	{
		$title = $_POST['title'];
	}
	if(!isset($_POST["infund"]) || $_POST["infund"] == '')
	{
		$errorMsg = $errorMsg . "充值金额不允许为空!<br>";
	}
	else
	{
		$infund = $_POST["infund"];
	}
	if(!isset($_POST["give_fund"]) || $_POST["give_fund"] == '')
	{
		$errorMsg = $errorMsg . "赠送金额不允许为空!<br>";
	}
	else
	{
		$give_fund = $_POST["give_fund"];
	}
	
	if($errorMsg == '')
	{
		$config[DAOIMPL]->updateFacevalue($_POST["id"], array("title"=>$title, "infund"=>$infund, "give_fund"=>$give_fund));
		$facevalue = $config[DAOIMPL]->getFacevalue($_POST["id"]);
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="facevalue.php">面值管理</a> -> 编辑面值
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>面值管理</h3>
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
		                <label>充值方式</label><input class="txt" type="text" name="title" value="<?php echo $facevalue["title"];?>">
		            </div>
		            <div class="item">
		                <label>充值金额</label><input class="txt" type="value" name="infund" value="<?php echo $facevalue["infund"];?>">
		            </div>
		            <div class="item">
		                <label>赠送金额</label><input class="txt" type="value" name="give_fund" value="<?php echo $facevalue["give_fund"];?>">
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