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

$remand_status = 0x03;
if(isset($_REQUEST['remand_status']))
{
	$remand_status = $_REQUEST['remand_status'];
	if($remand_status <= 0)
		$remand_status = 0x03;
}

$total_remand_count = $config[DAOIMPL]->getRemandCount($remand_status);
$total_page = ($total_remand_count % $number_per_page == 0) ? (int)($total_remand_count / $number_per_page) : ((int)($total_remand_count / $number_per_page) + 1);

$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
	if($current_page >= $total_page)
		$current_page = $total_page;
}

$rs = $config[DAOIMPL]->getRemands($remand_status, $current_page, $number_per_page);
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
		batch_delete_link[0].href = "remands_delete.php?batch=1&id=" + ids;
	}
}

function filterRemandStatus(remand_status)
{
	window.location = "<?php echo $config[ADMINBASEURL] . "remands.php?remand_status="; ?>" + remand_status + "&page=1&number_per_page=<?php echo $number_per_page;?>";
}

</SCRIPT>
<div class="mwin" id="page">
    <div class="hd radius5tr clearfix">
        <h3>预约送回</h3>
    </div>
    <div class="bd">
        <p><a onclick="batch_delete()" href="" name="batch_delete_link">删除</a> <a href="remands.php?remand_status=<?php echo $remand_status;?>&number_per_page=<?php echo $number_per_page;?>">刷新</a> 筛选 <select name="remand_status" id="remand_status" onchange="return filterRemandStatus(document.getElementById('remand_status').options[document.getElementById('remand_status').selectedIndex].value);">
							<option value="3"<?php if($remand_status==0x03) echo " selected"; ?>>全部</option>
							<option value="1"<?php if($remand_status==0x01) echo " selected"; ?>><?php echo $config[DAOIMPL]->getRemandStatusDescription(0x01); ?></option>
							<option value="2"<?php if($remand_status==0x02) echo " selected"; ?>><?php echo $config[DAOIMPL]->getRemandStatusDescription(0x02); ?></option>
						</select> 每页显示 << <?php if($number_per_page != 5) { ?><a href="remands.php?remand_status=<?php echo $remand_status;?>&number_per_page=5">5</a><?php } else { ?>5<?php } ?> <?php if($number_per_page != 10) { ?><a href="remands.php?remand_status=<?php echo $remand_status;?>&number_per_page=10">10</a><?php } else { ?>10<?php } ?> <?php if($number_per_page != 20) { ?><a href="remands.php?remand_status=<?php echo $remand_status;?>&number_per_page=20">20</a><?php } else { ?>20<?php } ?> <?php if($number_per_page != 30) { ?><a href="remands.php?remand_status=<?php echo $remand_status;?>&number_per_page=30">30</a><?php } else { ?>30<?php } ?> <?php if($number_per_page != 50) { ?><a href="remands.php?remand_status=<?php echo $remand_status;?>&number_per_page=50">50</a><?php } else { ?>50<?php } ?> >></p>
		<div class="grid radius5">
		    <table>
		        <colgroup>
		            <col width="42">
		            <col width="96">
					<col width="156">
		            <col width="54">
		            <col>
		        </colgroup>
		        <thead>
		            <tr>
		                <th class="center"><input type="checkbox" name="selectAll" value="selectAll" onclick="ck()"></th>
						<th>订单编号</th>
						<th>预约送回时间</th>
		                <th>状态</th>
		                <th>操作</th>
		            </tr>
		        <thead>
		        <tbody>
		            <?php for($i = 0; $i < mysql_num_rows($rs); $i++) 
					{ 
						$row = mysql_fetch_array($rs);
						$order_serial = '';
						$order_id = 0;
						if($row['OrderID'] > 0)
						{
							$row_order = $config[DAOIMPL]->getOrder($row['OrderID']);
							$order_serial = $row_order['OrderSerial'];
							$order_id = $row_order['id'];
						}
					?>
		            <tr>
		                <td class="center"><input type="checkbox" name="ids" value="<?php echo $row['ID'];?>"></td>
		                <td><?php if($order_id != 0) echo "<a href='orders_edit.php?id={$order_id}'>";?><?php echo $order_serial; ?><?php if($order_id != 0) echo "</a>";?></td>
						<td><?php echo $row["RemandDate"] . " " . $row["RemandTime"]; ?></td>
		                <td><?php echo $config[DAOIMPL]->getRemandStatusDescription($row['Status']); ?></td>
		                <td class="last"><a href="remands_edit.php?id=<?php echo $row['id'];?>">编辑</a> <a href="remands_delete.php?id=<?php echo $row['id'];?>&remand_status=<?php echo $remand_status;?>&page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page; ?>">删除</a></td>
		            </tr>
		            <?php 
					} 
					?>
		        </tbody>
		        <tfoot>
		            <tr>
		                <td colspan="2" class="allbox">
		                    
		                </td>
		                <td colspan="4" class="last">
							<a href="remands.php?remand_status=<?php echo $remand_status;?>&page=<?php echo $current_page - 1;?>&number_per_page=<?php echo $number_per_page;?>">&lt;&lt;</a>
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
										<a href="remands.php?remand_status=<?php echo $remand_status;?>&page=<?php echo $i + 1; ?>&number_per_page=<?php echo $number_per_page;?>"><?php echo $i + 1;?></a>
							<?php
									}
								}
							?>
		                    <a href="remands.php?remand_status=<?php echo $remand_status;?>&page=<?php echo $current_page + 1;?>&number_per_page=<?php echo $number_per_page;?>">&gt;&gt;</a>  
		                </td>
		            </tr>
		        </tfoot>
		    </table>
		</div>
        
    </div>
</div>
