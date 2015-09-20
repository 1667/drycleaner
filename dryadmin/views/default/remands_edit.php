<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '编辑预约送回成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$remand = $config[DAOIMPL]->getRemand($_REQUEST["id"]);

$order_id = 0;
$order_serial = '';
if($remand['OrderID'] > 0)
{
	$row_order = $config[DAOIMPL]->getOrder($remand['OrderID']);
	$order_serial = $row_order['OrderSerial'];
	$order_id = $row_order['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$remandStatus = 0;
	
	if(!isset($_POST["remandStatus"]) || $_POST["remandStatus"] == '')
	{
		$errorMsg = $errorMsg . "状态不允许为空!<br>";
	}
	else
	{
		$remandStatus = $_POST['remandStatus'];
	}
	
	if($errorMsg == '')
	{
		$config[DAOIMPL]->updateRemand($_POST["id"], array("Status"=>$remandStatus));
		$remand = $config[DAOIMPL]->getRemand($_POST["id"]);
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="remands.php">预约送回</a> -> 编辑预约送回
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑预约送回</h3>
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
		    <form action="?" method="POST">
		        <fieldset class="radius5">
					<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">
		            <div class="item">
		                <label>订单编号</label><?php if($order_id != 0) echo "<a href='orders_edit.php?id={$order_id}'>";?><?php echo $order_serial; ?><?php if($order_id != 0) echo "</a>";?>
		            </div>
		            <div class="item">
		                <label>预约送回时间</label><?php echo $remand["RemandDate"] . " " . $remand["RemandTime"]; ?>
		            </div>
		            <div class="item">
		                <label>备注</label><?php echo $remand["Memo"]; ?>
		            </div>
		            <div class="item">
		                <label>处理状态</label>
						<select name="remandStatus">
							<option value="1"<?php if($remand["Status"]==0x01) echo " selected"; ?>><?php echo $config[DAOIMPL]->getRemandStatusDescription(0x01); ?></option>
							<option value="2"<?php if($remand["Status"]==0x02) echo " selected"; ?>><?php echo $config[DAOIMPL]->getRemandStatusDescription(0x02); ?></option>
						</select>
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