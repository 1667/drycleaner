<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '编辑用户评价成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$evaluation = $config[DAOIMPL]->getEvaluation($_REQUEST["id"]);

$user_name = '';
$user_id = 0;
if($evaluation['UserID'] > 0)
{
	$row_user = $config[DAOIMPL]->getUserEx($evaluation['UserID']);
	$user_name = $row_user['UserName'];
	$user_id = $row_user['id'];
}

$order_serial = '';
$order_id = 0;
if($evaluation['OrderID'] > 0)
{
	$row_order = $config[DAOIMPL]->getOrder($evaluation['OrderID']);
	$order_serial = $row_order['OrderSerial'];
	$order_id = $row_order['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="evaluations.php">用户评价</a> -> 编辑用户评价
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑用户评价</h3>
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
		                <label>用户</label><?php if($user_id != 0) echo "<a href='members_edit.php?id={$user_id}'>";?><?php echo $user_name; ?><?php if($order_id != 0) echo "</a>";?>
		            </div>
		            <div class="item">
		                <label>订单编号</label><?php if($order_id != 0) echo "<a href='orders_edit.php?id={$order_id}'>";?><?php echo $order_serial; ?><?php if($order_id != 0) echo "</a>";?>
		            </div>
		            <div class="item">
		                <label>评价时间</label><?php echo $evaluation["EvaluationTime"]; ?>
		            </div>
		            <div class="item">
		                <label>客服人员服务态度</label><?php echo $config[DAOIMPL]->getEvaluationDescription($evaluation["CustomServiceAttitude"]); ?>
		            </div>
		            <div class="item">
		                <label>取送速度和及时性</label><?php echo $config[DAOIMPL]->getEvaluationDescription($evaluation["QussSpeed"]); ?>
		            </div>
		            <div class="item">
		                <label>取送人员服务态度</label><?php echo $config[DAOIMPL]->getEvaluationDescription($evaluation["QussStaffServiceAttitude"]); ?>
		            </div>
		            <div class="item">
		                <label>洗涤品质评价</label><?php echo $config[DAOIMPL]->getEvaluationDescription($evaluation["DryQuality"]); ?>
		            </div>
		            <div class="item">
		                <label>整体服务评价</label><?php echo $config[DAOIMPL]->getEvaluationDescription($evaluation["EntireService"]); ?>
		            </div>
		            <div class="item">
		                <label>备注</label><?php echo $evaluation["Memo"]; ?>
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