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

$total_suggestion_count = $config[DAOIMPL]->getSuggestionCount();
$total_page = ($total_suggestion_count % $number_per_page == 0) ? (int)($total_suggestion_count / $number_per_page) : ((int)($total_suggestion_count / $number_per_page) + 1);

$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
	if($current_page >= $total_page)
		$current_page = $total_page;
}

$rs = $config[DAOIMPL]->getSuggestions($current_page, $number_per_page);
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
		batch_delete_link[0].href = "suggestions_delete.php?batch=1&id=" + ids;
	}
}

</SCRIPT>
<div class="mwin" id="page">
    <div class="hd radius5tr clearfix">
        <h3>建议管理</h3>
    </div>
    <div class="bd">
        <p><a onclick="batch_delete()" href="" name="batch_delete_link">删除</a> <a href="suggestions.php?number_per_page=<?php echo $number_per_page;?>">刷新</a>  每页显示 << <?php if($number_per_page != 5) { ?><a href="suggestions.php?number_per_page=5">5</a><?php } else { ?>5<?php } ?> <?php if($number_per_page != 10) { ?><a href="suggestions.php?number_per_page=10">10</a><?php } else { ?>10<?php } ?> <?php if($number_per_page != 20) { ?><a href="suggestions.php?number_per_page=20">20</a><?php } else { ?>20<?php } ?> <?php if($number_per_page != 30) { ?><a href="suggestions.php?number_per_page=30">30</a><?php } else { ?>30<?php } ?> <?php if($number_per_page != 50) { ?><a href="suggestions.php?number_per_page=50">50</a><?php } else { ?>50<?php } ?> >></p>
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
						<th>会员名</th>
						<th>建议主题</th>
						<th>建议时间</th>
						<th>联系人</th>
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
					?>
		            <tr>
		                <td class="center"><input type="checkbox" name="ids" value="<?php echo $row['id'];?>"></td>
						<td><?php if($user_id != 0) echo "<a href='users_view.php?id={$user_id}'>";?><?php echo $user_name; ?><?php if($user_id != 0) echo "</a>";?></td>
						<td><?php echo $row["Title"]; ?></td>
						<td><?php echo $row["SuggestionTime"]; ?></td>
						<td><?php echo $row["UserName"]; ?></td>
		                <td class="last"><a href="suggestions_edit.php?id=<?php echo $row['id'];?>">编辑</a> <a href="suggestions_delete.php?id=<?php echo $row['id'];?>&page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page; ?>">删除</a></td>
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
							<a href="suggestions.php?page=<?php echo $current_page - 1;?>&number_per_page=<?php echo $number_per_page;?>">&lt;&lt;</a>
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
										<a href="suggestions.php?page=<?php echo $i + 1; ?>&number_per_page=<?php echo $number_per_page;?>"><?php echo $i + 1;?></a>
							<?php
									}
								}
							?>
		                    <a href="suggestions.php?page=<?php echo $current_page + 1;?>&number_per_page=<?php echo $number_per_page;?>">&gt;&gt;</a>  
		                </td>
		            </tr>
		        </tfoot>
		    </table>
		</div>
        
    </div>
</div>
