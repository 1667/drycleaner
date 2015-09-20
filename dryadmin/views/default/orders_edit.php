<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '编辑订单成功';
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

$order_status = 0x01FF;
if(isset($_REQUEST['order_status']))
{
	$order_status = $_REQUEST['order_status'];
	if($order_status <= 0)
		$order_status = 0x01FF;
}

$order = $config[DAOIMPL]->getOrder($_REQUEST["id"]);

$user_id = 0;
$user_name = '';
if($order['UserID'] > 0)
{
	$row_user = $config[DAOIMPL]->getUserEx($order['UserID']);
	$user_name = $row_user['UserName'];
	$user_id = $row_user['id'];
}

$goods_id = 0;
$goods_name = '';
if($order['ClothingGoodsID'] > 0)
{
	$row_goods = $config[DAOIMPL]->getGoods($order['ClothingGoodsID']);
	$goods_name = $row_goods['GoodsName'];
	$goods_id = $row_goods['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$createTime = date('Y-m-d H:i:s',time());
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
		$config[DAOIMPL]->updateOrder($_POST["id"], array("CreateTime"=>$createTime , "Status"=>$orderStatus));
		$order = $config[DAOIMPL]->getOrder($_POST["id"]);
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="orders.php?order_status=<?=$order_status?>&page=<?=$current_page?>&number_per_page=<?=$number_per_page?>">订单管理</a> -> 编辑订单
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑订单</h3>
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
	
	$order_clothing_count = $config[DAOIMPL]->getOrderClothingCount($_REQUEST["id"]);
	$order_clothings_arr = $config[DAOIMPL]->getOrderClothings(1,-1,$_REQUEST["id"]);
	$order_clothing_ids = array();
	$order_clothing_counts = array();
	$order_clothing_names = array();
	for($j = 0 ; $j < $order_clothing_count ; $j++)
	{
		$order_clothing = mysql_fetch_array($order_clothings_arr);
		$order_clothing_ids[] = $order_clothing["ClothingGoodsID"];
		$order_clothing_counts[] = $order_clothing["OrderCount"];
		$row_goods = $config[DAOIMPL]->getGoods($order_clothing["ClothingGoodsID"]);
		$order_clothing_names[] = $row_goods['GoodsName'];
	}
?>
		<div class="commonform">
		    <form action="?" method="POST">
		        <fieldset class="radius5">
					<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">
		            <div class="item">
		                <label>订单编号</label><?php echo $order["OrderSerial"]; ?>
		            </div>
		            <div class="item">
		                <label>用户</label><?php if($user_id != 0) echo "<a href='members_edit.php?id={$user_id}'>";?><?php echo $user_name; ?><?php if($user_id != 0) echo "</a>";?>
		            </div>
		            <div class="item">
		                <label>产品</label><?php for($j = 0 ; $j < count($order_clothing_ids) ; $j++) { echo "<a href='clothinggoods_edit.php?id={$order_clothing_ids[$j]}'>";?><?php echo $order_clothing_names[$j] . "(" . $order_clothing_counts[$j] . ")"; ?><?php echo "</a> "; } ?>
		            </div>
		            <div class="item">
		                <label>总金额</label><?php echo $order["TotalAmount"]; ?>
		            </div>
		            <div class="item">
		                <label>积分抵扣</label><?php echo $order["PointsDeduction"]; ?>
		            </div>
		            <div class="item">
		                <label>优惠券抵扣</label><?php echo $order["CouponDeduction"]; ?>
		            </div>
		            <div class="item">
		                <label>实付金额</label><?php echo $order["PayAmount"]; ?>
		            </div>
		            <div class="item">
		                <label>下单时间</label><?php echo $order["OrderTime"]; ?>
		            </div>
		            <div class="item">
		                <label>修改时间</label><?php echo $order["CreateTime"]; ?>
		            </div>
		            <div class="item">
		                <label>订单状态</label>
						<select name="orderStatus">
							<option value="1"<?php if($order["Status"]==0x0001) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0001); ?></option>
							<option value="2"<?php if($order["Status"]==0x0002) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0002); ?></option>
							<option value="4"<?php if($order["Status"]==0x0004) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0004); ?></option>
							<option value="8"<?php if($order["Status"]==0x0008) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0008); ?></option>
							<option value="16"<?php if($order["Status"]==0x0010) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0010); ?></option>
							<option value="32"<?php if($order["Status"]==0x0020) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0020); ?></option>
							<option value="64"<?php if($order["Status"]==0x0040) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0040); ?></option>
							<option value="128"<?php if($order["Status"]==0x0080) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0080); ?></option>
							<option value="256"<?php if($order["Status"]==0x0100) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0100); ?></option>
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