<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$number_per_page = 10;
if(isset($_REQUEST['number_per_page']))
{
	$number_per_page = $_REQUEST['number_per_page'];
	if($number_per_page <= 0)
		$number_per_page = 10;
}

$order_status = 0x01FF;
if(isset($_REQUEST['order_status']))
{
	$order_status = $_REQUEST['order_status'];
	if($order_status <= 0)
		$order_status = 0x01FF;
}

$total_order_count = $config[DAOIMPL]->getOrderCount($order_status);
$total_page = ($total_order_count % $number_per_page == 0) ? (int)($total_order_count / $number_per_page) : ((int)($total_order_count / $number_per_page) + 1);

$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
	if($current_page >= $total_page)
		$current_page = $total_page;
}

$rs = $config[DAOIMPL]->getOrders($order_status, $current_page, $number_per_page);
?>

<SCRIPT LANGUAGE="JavaScript">

function ck()
{
    var input = document.getElementsByTagName("input");
	var checkAllInput = document.getElementsByName("selectAll");
	var b = checkAllInput[0].checked;

    for (var i=0;i<input.length ;i++ )
    {
        if(input[i].type=="checkbox" && input[i].value != "selectAll")
            input[i].checked = b;
    }
}

function batch_delete()
{
	var idsInput = document.getElementsByName("ids");
	var batch_delete_link = document.getElementsByName("batch_delete_link");
	var ids = '';
	
    for (var i=0;i<idsInput.length;i++ )
    {
        if(idsInput[i].checked)
		{
			if(ids != '')
			{
				ids += ',';
			}
			ids += idsInput[i].value;
		}
    }
	if(ids != '')
	{
		batch_delete_link[0].href = "orders_delete.php?batch=1&id=" + ids;
	}
}

function filterOrderStatus(order_status)
{
	window.location = "<?php echo $config[ADMINBASEURL] . "orders.php?order_status="; ?>" + order_status + "&page=1&number_per_page=<?php echo $number_per_page;?>";
}
</SCRIPT>
<div class="mwin" id="page">
    <div class="hd radius5tr clearfix">
        <h3>订单管理</h3>
    </div>
    <div class="bd">
        <p><a onclick="batch_delete()" href="" name="batch_delete_link">删除</a> <a href="orders.php?order_status=<?php echo $order_status;?>&number_per_page=<?php echo $number_per_page;?>">刷新</a> 筛选 <select name="order_status" id="order_status" onchange="return filterOrderStatus(document.getElementById('order_status').options[document.getElementById('order_status').selectedIndex].value);">
							<option value="511"<?php if($order_status==0x01FF) echo " selected"; ?>>全部</option>
							<option value="1"<?php if($order_status==0x0001) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0001); ?></option>
							<option value="2"<?php if($order_status==0x0002) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0002); ?></option>
							<option value="4"<?php if($order_status==0x0004) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0004); ?></option>
							<option value="8"<?php if($order_status==0x0008) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0008); ?></option>
							<option value="16"<?php if($order_status==0x0010) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0010); ?></option>
							<option value="32"<?php if($order_status==0x0020) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0020); ?></option>
							<option value="64"<?php if($order_status==0x0040) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0040); ?></option>
							<option value="128"<?php if($order_status==0x0080) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0080); ?></option>
							<option value="256"<?php if($order_status==0x0100) echo " selected"; ?>><?php echo $config[DAOIMPL]->getOrderDescription(0x0100); ?></option>
						</select> 每页显示 << <?php if($number_per_page != 5) { ?><a href="orders.php?order_status=<?php echo $order_status;?>&number_per_page=5">5</a><?php } else { ?>5<?php } ?> <?php if($number_per_page != 10) { ?><a href="orders.php?order_status=<?php echo $order_status;?>&number_per_page=10">10</a><?php } else { ?>10<?php } ?> <?php if($number_per_page != 20) { ?><a href="orders.php?order_status=<?php echo $order_status;?>&number_per_page=20">20</a><?php } else { ?>20<?php } ?> <?php if($number_per_page != 30) { ?><a href="orders.php?order_status=<?php echo $order_status;?>&number_per_page=30">30</a><?php } else { ?>30<?php } ?> <?php if($number_per_page != 50) { ?><a href="orders.php?order_status=<?php echo $order_status;?>&number_per_page=50">50</a><?php } else { ?>50<?php } ?> >></p>
		<div class="grid radius5">
		    <table>
		        <colgroup>
		            <col width="42">
		            <col width="96">
					<col width="76">
		            <col width="94">
					<col width="124">
					<col width="64">
		            <col width="66">
		            <col>
		        </colgroup>
		        <thead>
		            <tr>
		                <th class="center"><input type="checkbox" name="selectAll" value="selectAll" onclick="ck()"></th>
						<th>订单编号</th>
						<th>用户</th>
		                <th>产品</th>
						<th>下单时间</th>
						<th>总金额</th>
						<th>订单状态</th>
		                <th>操作</th>
		            </tr>
		        <thead>
		        <tbody>
		            <?php for($i = 0; $i < mysql_num_rows($rs); $i++) 
					{ 
						$row = mysql_fetch_array($rs);
						$user_id = 0;
						$user_name = '';
						if($row['UserID'] > 0)
						{
							$row_user = $config[DAOIMPL]->getUserEx($row['UserID']);
							$user_name = $row_user['UserName'];
							$user_id = $row_user['id'];
						}
						
						$order_clothing_count = $config[DAOIMPL]->getOrderClothingCount($row['id']);
						$order_clothings_arr = $config[DAOIMPL]->getOrderClothings(1,-1,$row['id']);
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
		            <tr>
		                <td class="center"><input type="checkbox" name="ids" value="<?php echo $row['id'];?>"></td>
		                <td><?php echo $row['OrderSerial']; ?></td>
						<td><?php if($user_id != 0) echo "<a href='members_edit.php?id={$user_id}'>";?><?php echo $user_name; ?><?php if($user_id != 0) echo "</a>";?></td>
						<td><?php for($j = 0 ; $j < count($order_clothing_ids) ; $j++) { echo "<a href='clothinggoods_edit.php?id={$order_clothing_ids[$j]}'>";?><?php echo $order_clothing_names[$j] . "(" . $order_clothing_counts[$j] . ")"; ?><?php echo "</a> "; } ?></td>
						<td><?php echo $row['OrderTime']; ?></td>
						<td><?php echo $row['TotalAmount']; ?></td>
						<td><?php echo $config[DAOIMPL]->getOrderDescription($row['Status']); ?></td>
		                <td class="last"><a href="orders_edit.php?id=<?php echo $row['id'];?>&order_status=<?php echo $order_status; ?>&page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page; ?>">编辑</a> <a href="orders_delete.php?id=<?php echo $row['id'];?>&order_status=<?php echo $order_status; ?>&page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page; ?>">删除</a></td>
		            </tr>
		            <?php 
					} 
					?>
		        </tbody>
		        <tfoot>
		            <tr>
		                <td colspan="2" class="allbox">
		                    
		                </td>
		                <td colspan="7" class="last">
							<a href="orders.php?order_status=<?php echo $order_status; ?>&page=<?php echo $current_page - 1;?>&number_per_page=<?php echo $number_per_page;?>">&lt;&lt;</a>
							<?php
								
								for($i = 0 ; $i < $total_page ; $i++)
								{
									if($current_page == ($i + 1))
									{
							?>			
										<strong><?php echo $i + 1; ?></strong>
							<?php
									}
									else
									{
							?>
										<a href="orders.php?order_status=<?php echo $order_status; ?>&page=<?php echo $i + 1; ?>&number_per_page=<?php echo $number_per_page;?>"><?php echo $i + 1;?></a>
							<?php
									}
								}
							?>
		                    <a href="orders.php?order_status=<?php echo $order_status; ?>&page=<?php echo $current_page + 1;?>&number_per_page=<?php echo $number_per_page;?>">&gt;&gt;</a>  
		                </td>
		            </tr>
		        </tfoot>
		    </table>
		</div>
        
    </div>
</div>
