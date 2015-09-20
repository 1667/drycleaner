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

$from_where = 0;
if(isset($_REQUEST['from_where']))
{
	$from_where = $_REQUEST['from_where'];
	if($from_where <= 0)
		$from_where = 0;
}

$total_member_count = $config[DAOIMPL]->getMemberCount($from_where);
$total_page = ($total_member_count % $number_per_page == 0) ? (int)($total_member_count / $number_per_page) : ((int)($total_member_count / $number_per_page) + 1);

$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
	if($current_page >= $total_page)
		$current_page = $total_page;
}

$rs = $config[DAOIMPL]->getMembers($from_where, $current_page, $number_per_page);
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
		batch_delete_link[0].href = "members_delete.php?batch=1&id=" + ids;
	}
}

function filterMemberFromWhere(from_where)
{
	window.location = "<?php echo $config[ADMINBASEURL] . "members.php?from_where="; ?>" + from_where + "&page=1&number_per_page=<?php echo $number_per_page;?>";
}

</SCRIPT>
<div class="mwin" id="page">
    <div class="hd radius5tr clearfix">
        <h3>会员管理</h3>
    </div>
    <div class="bd">
        <p><a href="members_add.php">添加</a> <a onclick="batch_delete()" href="" name="batch_delete_link">删除</a> <a href="members.php?from_where=<?php echo $from_where;?>&number_per_page=<?php echo $number_per_page;?>">刷新</a> 筛选 <select name="from_where" id="from_where" onchange="return filterMemberFromWhere(document.getElementById('from_where').options[document.getElementById('from_where').selectedIndex].value);">
							<option value="0"<?php if($from_where==0) echo " selected"; ?>>全部</option>
							<option value="1"<?php if($from_where==1) echo " selected"; ?>><?php echo $config[DAOIMPL]->getMemberFromWhereDescription(1); ?></option>
							<option value="2"<?php if($from_where==2) echo " selected"; ?>><?php echo $config[DAOIMPL]->getMemberFromWhereDescription(2); ?></option>
							<option value="3"<?php if($from_where==3) echo " selected"; ?>><?php echo $config[DAOIMPL]->getMemberFromWhereDescription(3); ?></option>
						</select> 每页显示 << <?php if($number_per_page != 5) { ?><a href="members.php?from_where=<?php echo $from_where;?>&number_per_page=5">5</a><?php } else { ?>5<?php } ?> <?php if($number_per_page != 10) { ?><a href="members.php?from_where=<?php echo $from_where;?>&number_per_page=10">10</a><?php } else { ?>10<?php } ?> <?php if($number_per_page != 20) { ?><a href="members.php?from_where=<?php echo $from_where;?>&number_per_page=20">20</a><?php } else { ?>20<?php } ?> <?php if($number_per_page != 30) { ?><a href="members.php?from_where=<?php echo $from_where;?>&number_per_page=30">30</a><?php } else { ?>30<?php } ?> <?php if($number_per_page != 50) { ?><a href="members.php?from_where=<?php echo $from_where;?>&number_per_page=50">50</a><?php } else { ?>50<?php } ?> >></p>
		<div class="grid radius5">
		    <table>
		        <colgroup>
		            <col width="42">
					<col width="80">
					<col width="80">
					<col width="40">
		            <col width="80">
					<col width="100">
					<col width="100">
		            <col>
		        </colgroup>
		        <thead>
		            <tr>
		                <th class="center"><input type="checkbox" name="selectAll" value="selectAll" onclick="ck()"></th>
						<th>会员名</th>
						<th>真实姓名</th>
						<th>性别</th>
						<th>注册来源</th>
						<th>电话号码</th>
						<th>邮箱</th>
		                <th>操作</th>
		            </tr>
		        <thead>
		        <tbody>
		            <?php for($i = 0; $i < mysql_num_rows($rs); $i++) 
					{ 
						$row = mysql_fetch_array($rs);
					?>
		            <tr>
		                <td class="center"><input type="checkbox" name="ids" value="<?php echo $row['id'];?>"></td>
						<td><?php echo $row["UserName"]; ?></td>
						<td><?php echo $row["TrueName"]; ?></td>
						<td><?php echo $config[DAOIMPL]->getMemberSexDescription($row["Sex"]); ?></td>
						<td><?php echo $config[DAOIMPL]->getMemberFromWhereDescription($row["FromWhere"]); ?></td>
						<td><?php echo $row["PhoneNumber"]; ?></td>
						<td><?php echo $row["Email"]; ?></td>
		                <td class="last"><a href="members_edit.php?id=<?php echo $row['id'];?>">编辑</a> <a href="members_delete.php?id=<?php echo $row['id'];?>&page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page; ?>">删除</a></td>
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
							<a href="members.php?from_where=<?php echo $from_where;?>&page=<?php echo $current_page - 1;?>&number_per_page=<?php echo $number_per_page;?>">&lt;&lt;</a>
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
										<a href="members.php?from_where=<?php echo $from_where;?>&page=<?php echo $i + 1; ?>&number_per_page=<?php echo $number_per_page;?>"><?php echo $i + 1;?></a>
							<?php
									}
								}
							?>
		                    <a href="members.php?from_where=<?php echo $from_where;?>&page=<?php echo $current_page + 1;?>&number_per_page=<?php echo $number_per_page;?>">&gt;&gt;</a>  
		                </td>
		            </tr>
		        </tfoot>
		    </table>
		</div>
        
    </div>
</div>
