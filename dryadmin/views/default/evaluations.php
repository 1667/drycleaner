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

$total_evaluation_count = $config[DAOIMPL]->getEvaluationCount();
$total_page = ($total_evaluation_count % $number_per_page == 0) ? (int)($total_evaluation_count / $number_per_page) : ((int)($total_evaluation_count / $number_per_page) + 1);

$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
	if($current_page >= $total_page)
		$current_page = $total_page;
}

$rs = $config[DAOIMPL]->getEvaluations($current_page, $number_per_page);
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
		batch_delete_link[0].href = "evaluations_delete.php?batch=1&id=" + ids;
	}
}

</SCRIPT>
<div class="mwin" id="page">
    <div class="hd radius5tr clearfix">
        <h3>用户评价</h3>
    </div>
    <div class="bd">
        <p><a onclick="batch_delete()" href="" name="batch_delete_link">删除</a> <a href="evaluations.php?number_per_page=<?php echo $number_per_page;?>">刷新</a> 每页显示 << <?php if($number_per_page != 5) { ?><a href="evaluations.php?number_per_page=5">5</a><?php } else { ?>5<?php } ?> <?php if($number_per_page != 10) { ?><a href="evaluations.php?number_per_page=10">10</a><?php } else { ?>10<?php } ?> <?php if($number_per_page != 20) { ?><a href="evaluations.php?number_per_page=20">20</a><?php } else { ?>20<?php } ?> <?php if($number_per_page != 30) { ?><a href="evaluations.php?number_per_page=30">30</a><?php } else { ?>30<?php } ?> <?php if($number_per_page != 50) { ?><a href="evaluations.php?number_per_page=50">50</a><?php } else { ?>50<?php } ?> >></p>
		<div class="grid radius5">
		    <table>
		        <colgroup>
		            <col width="42">
		            <col width="96">
					<col width="126">
		            <col width="126">
					 <col width="110">
		            <col>
		        </colgroup>
		        <thead>
		            <tr>
		                <th class="center"><input type="checkbox" name="selectAll" value="selectAll" onclick="ck()"></th>
						<th>用户</th>
						<th>订单编号</th>
		                <th>评价时间</th>
						<th>评价</th>
		                <th>操作</th>
		            </tr>
		        <thead>
		        <tbody>
		            <?php for($i = 0; $i < mysql_num_rows($rs); $i++) 
					{ 
						$row = mysql_fetch_array($rs);
						
						$user_name = '';
						$user_id = 0;
						if($row['UserID'] > 0)
						{
							$row_user = $config[DAOIMPL]->getUserEx($row['UserID']);
							$user_name = $row_user['UserName'];
							$user_id = $row_user['id'];
						}
						
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
		                <td class="center"><input type="checkbox" name="ids" value="<?php echo $row['id'];?>"></td>
						<td><?php if($user_id != 0) echo "<a href='members_edit.php?id={$user_id}'>";?><?php echo $user_name; ?><?php if($user_id != 0) echo "</a>";?></td>
		                <td><?php if($order_id != 0) echo "<a href='orders_edit.php?id={$order_id}'>";?><?php echo $order_serial; ?><?php if($order_id != 0) echo "</a>";?></td>
						<td><?php echo $row["EvaluationTime"]; ?></td>
		                <td><?php echo "{$row["CustomServiceAttitude"]},{$row["QussSpeed"]},{$row["QussStaffServiceAttitude"]},{$row["DryQuality"]},{$row["EntireService"]}"; ?></td>
		                <td class="last"><a href="evaluations_edit.php?id=<?php echo $row['id'];?>">查看</a> <a href="evaluations_delete.php?id=<?php echo $row['id'];?>&page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page; ?>">删除</a></td>
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
							<a href="evaluations.php?page=<?php echo $current_page - 1;?>&number_per_page=<?php echo $number_per_page;?>">&lt;&lt;</a>
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
										<a href="evaluations.php?page=<?php echo $i + 1; ?>&number_per_page=<?php echo $number_per_page;?>"><?php echo $i + 1;?></a>
							<?php
									}
								}
							?>
		                    <a href="evaluations.php?page=<?php echo $current_page + 1;?>&number_per_page=<?php echo $number_per_page;?>">&gt;&gt;</a>  
		                </td>
		            </tr>
		        </tfoot>
		    </table>
		</div>
        
    </div>
</div>
