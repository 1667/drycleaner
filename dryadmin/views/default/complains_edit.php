<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '修改会员投诉信息成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$complain = $config[DAOIMPL]->getComplain($_REQUEST["id"]);

$order_id = 0;
$order_serial = '';
if($complain['OrderID'] > 0)
{
	$row_order = $config[DAOIMPL]->getOrder($complain["OrderID"]);
	$order_serial = $row_order['OrderSerial'];
	$order_id = $row_order['id'];
}

$user_id = 0;
$user_name = '';
if($complain['UserID'] > 0)
{
	$row_user = $config[DAOIMPL]->getUserEx($complain['UserID']);
	$user_name = $row_user['UserName'];
	$user_id = $row_user['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$handleTime = date('Y-m-d H:i:s',time());
	$handleResult = $_POST["handleResult"];
	$handleStatus = 1;
	
	if(!isset($_POST["handleStatus"]) || $_POST["handleStatus"] == '')
	{
		$errorMsg = $errorMsg . "处理状态不允许为空!<br>";
	}
	else
	{
		$handleStatus = intval($_POST["handleStatus"]);
		if(!($handleStatus >= 1 && $handleStatus <= 2))
		{
			$errorMsg = $errorMsg . "处理状态参数有误!<br>";
		}
	}
	
	if($errorMsg == '')
	{
		$config[DAOIMPL]->updateComplain($_POST["id"], array("HandleTime"=>$handleTime, "HandleResult"=>$handleResult, "Status"=>$handleStatus));
		$complain = $config[DAOIMPL]->getComplain($_POST["id"]);
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="complains.php">投诉管理</a> -> 编辑投诉信息
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑投诉信息</h3>
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
		                <label>用户</label><?php if($user_id != 0) echo "<a href='members_edit.php?id={$user_id}'>";?><?php echo $user_name; ?><?php if($user_id != 0) echo "</a>";?>
		            </div>
		            <div class="item">
		                <label>订单编号</label><?php if($order_id != 0) echo "<a href='orders_edit.php?id={$order_id}'>";?><?php echo $order_serial; ?><?php if($order_id != 0) echo "</a>";?>
		            </div>
		            <div class="item">
		                <label>投诉时间</label><?php echo $complain['ComplainTime']; ?>
		            </div>
		            <div class="item">
		                <label>投诉类型</label><?php echo $config[DAOIMPL]->getComplainTypeDescription($complain['Type']); ?>
		            </div>
		            <div class="item">
		                <label>投诉内容</label><?php echo $complain['Content']; ?>
		            </div>
		            <div class="item">
		                <label>联系电话</label><?php echo $complain['PhoneNumber']; ?>
		            </div>
		            <div class="item">
		                <label>处理时间</label><?php echo $complain['HandleTime']; ?>
		            </div>
		            <div class="item">
		                <label>处理状态</label>
						<select name="handleStatus"><option value="1"<?php if($complain["Status"]==1) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainStatusDescription(1); ?></option>
							<option value="2"<?php if($complain["Status"]==2) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainStatusDescription(2); ?></option>
						</select>
		            </div>
		            <div class="item">
		                <label>处理内容</label><textarea name="handleResult" cols="50" rows="8"><?php echo $complain['HandleResult']; ?></textarea>
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