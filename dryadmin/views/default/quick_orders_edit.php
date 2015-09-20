<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '编辑快捷订单成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$number_per_page = 10;
if(isset($_REQUEST['number_per_page']))
{
	$number_per_page = $_REQUEST['number_per_page'];
	if($number_per_page <= 0)
		$number_per_page = 10;
}
$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
}

$order_status = 0x000F;
if(isset($_REQUEST['order_status']))
{
	$order_status = $_REQUEST['order_status'];
	if($order_status <= 0)
		$order_status = 0x000F;
}

$order = $config[DAOIMPL]->getQuickOrder($_REQUEST["id"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$orderStatus = 0;
	
	if(!isset($_POST["orderStatus"]) || $_POST["orderStatus"] == '')
	{
		$errorMsg = $errorMsg . "状态不允许为空!<br>";
	}
	else
	{
		$orderStatus = $_POST['orderStatus'];
	}
	
	if($errorMsg == '')
	{
		$config[DAOIMPL]->updateQuickOrder($_POST["id"], array("Status"=>$orderStatus));
		$order = $config[DAOIMPL]->getQuickOrder($_POST["id"]);
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="quick_orders.php?order_status=<?=$order_status?>&page=<?=$current_page?>&number_per_page=<?=$number_per_page?>">快捷订单管理</a> -> 编辑快捷订单
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑快捷订单</h3>
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
		                <label>姓名</label><?php echo $order["UserName"]; ?>
		            </div>
		            <div class="item">
		                <label>联系手机</label><?php echo $order["PhoneNumber"]; ?>
		            </div>
		            <div class="item">
		                <label>联系电话</label><?php echo $order['PreTel'] . "-" . $order['Tel'] . "-" . $row['LaterTel']; ?>
		            </div>
		            <div class="item">
		                <label>上门收取时间</label><?php echo $order['getdate'] . " " . $order['gettime']; ?>
		            </div>
		            <div class="item">
		                <label>省份</label><?php $arr = $config[DAOIMPL]->getProvince($order["Province"]); if(count($arr) > 0) echo $arr['name']; ?>
		            </div>
		            <div class="item">
		                <label>城市</label><?php $arr = $config[DAOIMPL]->getCity($order["City"]); if(count($arr) > 0) echo $arr['name']; ?>
		            </div>
		            <div class="item">
		                <label>地区</label><?php $arr = $config[DAOIMPL]->getRegion($order["Region"]); if(count($arr) > 0) echo $arr['name']; ?>
		            </div>
		            <div class="item">
		                <label>详细地址</label><?php echo $order["DetailAddress"]; ?>
		            </div>
		            <div class="item">
		                <label>下单时间</label><?php echo $order["CreateTime"]; ?>
		            </div>
		            <div class="item">
		                <label>订单状态</label>
						<select name="orderStatus">
							<option value="1"<?php if($order["Status"]==0x0001) echo " selected"; ?>><?php echo $config[DAOIMPL]->getQuickOrderDescription(0x0001); ?></option>
							<option value="2"<?php if($order["Status"]==0x0002) echo " selected"; ?>><?php echo $config[DAOIMPL]->getQuickOrderDescription(0x0002); ?></option>
							<option value="4"<?php if($order["Status"]==0x0004) echo " selected"; ?>><?php echo $config[DAOIMPL]->getQuickOrderDescription(0x0004); ?></option>
							<option value="8"<?php if($order["Status"]==0x0008) echo " selected"; ?>><?php echo $config[DAOIMPL]->getQuickOrderDescription(0x0008); ?></option>
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