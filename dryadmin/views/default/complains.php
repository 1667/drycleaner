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

$complain_status = 3;
if(isset($_REQUEST['complain_status']))
{
	$complain_status = $_REQUEST['complain_status'];
	if($complain_status <= 0)
		$complain_status = 3;
}

$complain_type = 100;
if(isset($_REQUEST['complain_type']))
{
	$complain_type = $_REQUEST['complain_type'];
	if($complain_type <= 0)
		$complain_type = 100;
}

$total_complain_count = $config[DAOIMPL]->getComplainCount($complain_type, $complain_status);
$total_page = ($total_complain_count % $number_per_page == 0) ? (int)($total_complain_count / $number_per_page) : ((int)($total_complain_count / $number_per_page) + 1);

$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
	if($current_page >= $total_page)
		$current_page = $total_page;
}

$rs = $config[DAOIMPL]->getComplains($complain_type, $complain_status, $current_page, $number_per_page);
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
		batch_delete_link[0].href = "complains_delete.php?batch=1&complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&id=" + ids;
	}
}

function filterComplain(complain_type, complain_status)
{
	window.location = "<?php echo $config[ADMINBASEURL] . "complains.php?complain_type="; ?>" + complain_type + "<?php echo "&complain_status="; ?>" + complain_status + "&page=1&number_per_page=<?php echo $number_per_page;?>";
}

</SCRIPT>
<div class="mwin" id="page">
    <div class="hd radius5tr clearfix">
        <h3>投诉管理</h3>
    </div>
    <div class="bd">
        <p><a onclick="batch_delete()" href="" name="batch_delete_link">删除</a> <a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&number_per_page=<?php echo $number_per_page;?>">刷新</a>  筛选 <select name="complain_type" id="complain_type" onchange="return filterComplain(document.getElementById('complain_type').options[document.getElementById('complain_type').selectedIndex].value, document.getElementById('complain_status').options[document.getElementById('complain_status').selectedIndex].value);">
							<option value="100"<?php if($complain_type==100) echo " selected"; ?>>全部</option>
							<option value="1"<?php if($complain_type==1) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainTypeDescription(1); ?></option>
							<option value="2"<?php if($complain_type==2) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainTypeDescription(2); ?></option>
							<option value="3"<?php if($complain_type==3) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainTypeDescription(3); ?></option>
							<option value="4"<?php if($complain_type==4) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainTypeDescription(4); ?></option>
							<option value="5"<?php if($complain_type==5) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainTypeDescription(5); ?></option>
							<option value="6"<?php if($complain_type==6) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainTypeDescription(6); ?></option>
							<option value="7"<?php if($complain_type==7) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainTypeDescription(7); ?></option>
						</select> <select name="complain_status" id="complain_status" onchange="return filterComplain(document.getElementById('complain_type').options[document.getElementById('complain_type').selectedIndex].value, document.getElementById('complain_status').options[document.getElementById('complain_status').selectedIndex].value);">
							<option value="3"<?php if($complain_status==3) echo " selected"; ?>>全部</option>
							<option value="1"<?php if($complain_status==1) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainStatusDescription(1); ?></option>
							<option value="2"<?php if($complain_status==2) echo " selected"; ?>><?php echo $config[DAOIMPL]->getComplainStatusDescription(2); ?></option>
						</select>每页显示 << <?php if($number_per_page != 5) { ?><a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&number_per_page=5">5</a><?php } else { ?>5<?php } ?> <?php if($number_per_page != 10) { ?><a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&number_per_page=10">10</a><?php } else { ?>10<?php } ?> <?php if($number_per_page != 20) { ?><a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&number_per_page=20">20</a><?php } else { ?>20<?php } ?> <?php if($number_per_page != 30) { ?><a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&number_per_page=30">30</a><?php } else { ?>30<?php } ?> <?php if($number_per_page != 50) { ?><a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&number_per_page=50">50</a><?php } else { ?>50<?php } ?> >></p>
		<div class="grid radius5">
		    <table>
		        <colgroup>
		            <col width="42">
					<col width="80">
					<col width="80">
					<col width="100">
		            <col width="130">
					<col width="100">
					<col width="50">
		            <col>
		        </colgroup>
		        <thead>
		            <tr>
		                <th class="center"><input type="checkbox" name="selectAll" value="selectAll" onclick="ck()"></th>
						<th>订单</th>
						<th>用户</th>
						<th>投诉类别</th>
						<th>投诉时间</th>
						<th>联系电话</th>
						<th>状态</th>
		                <th>操作</th>
		            </tr>
		        <thead>
		        <tbody>
		            <?php for($i = 0; $i < mysql_num_rows($rs); $i++) 
					{ 
						$row = mysql_fetch_array($rs);
						
						$order_id = 0;
						$order_serial = '';
						if($row['OrderID'] > 0)
						{
							$row_order = $config[DAOIMPL]->getOrder($row['OrderID']);
							$order_serial = $row_order['OrderSerial'];
							$order_id = $row_order['id'];
						}
						
						$user_id = 0;
						$user_name = '';
						if($row['UserID'] > 0)
						{
							$row_user = $config[DAOIMPL]->getUserEx($row['UserID']);
							$user_name = $row_user['UserName'];
							$user_id = $row_user['id'];
						}
					?>
		            <tr>
		                <td class="center"><input type="checkbox" name="ids" value="<?php echo $row['id'];?>"></td>
						<td><?php if($order_id != 0) echo "<a href='orders_edit.php?id={$order_id}'>";?><?php echo $order_serial; ?><?php if($order_id != 0) echo "</a>";?></td>
						<td><?php if($user_id != 0) echo "<a href='members_edit.php?id={$user_id}'>";?><?php echo $user_name; ?><?php if($user_id != 0) echo "</a>";?></td>
						<td><?php echo $config[DAOIMPL]->getComplainTypeDescription($row["Type"]); ?></td>
						<td><?php echo $row["ComplainTime"]; ?></td>
						<td><?php echo $row["PhoneNumber"]; ?></td>
						<td><?php echo $config[DAOIMPL]->getComplainStatusDescription($row["Status"]); ?></td>
		                <td class="last"><a href="complains_edit.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&id=<?php echo $row['id'];?>">编辑</a> <a href="complains_delete.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&id=<?php echo $row['id'];?>&page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page; ?>">删除</a></td>
		            </tr>
		            <?php 
					} 
					?>
		        </tbody>
		        <tfoot>
		            <tr>
		                <td colspan="2" class="allbox">
		                    
		                </td>
		                <td colspan="6" class="last">
							<a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&page=<?php echo $current_page - 1;?>&number_per_page=<?php echo $number_per_page;?>">&lt;&lt;</a>
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
										<a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&page=<?php echo $i + 1; ?>&number_per_page=<?php echo $number_per_page;?>"><?php echo $i + 1;?></a>
							<?php
									}
								}
							?>
		                    <a href="complains.php?complain_type=<?php echo $complain_type; ?>&complain_status=<?php echo $complain_status; ?>&page=<?php echo $current_page + 1;?>&number_per_page=<?php echo $number_per_page;?>">&gt;&gt;</a>  
		                </td>
		            </tr>
		        </tfoot>
		    </table>
		</div>
        
    </div>
</div>
