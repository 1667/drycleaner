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

$type = 0;
if(isset($_REQUEST['type']))
{
	$type = $_REQUEST['type'];
	if($type < 0)
		$type = 0;
}

$total_article_count = $config[DAOIMPL]->getArticleCount($type);
$total_page = ($total_article_count % $number_per_page == 0) ? (int)($total_article_count / $number_per_page) : ((int)($total_article_count / $number_per_page) + 1);

$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
	if($current_page >= $total_page)
		$current_page = $total_page;
}

$rs = $config[DAOIMPL]->getArticles($type, $current_page, $number_per_page);
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
		batch_delete_link[0].href = "article_delete.php?batch=1&type=<?php echo $type; ?>&id=" + ids;
	}
}

function filterType(type)
{
	window.location = "<?php echo $config[ADMINBASEURL] . "article.php?type="; ?>" + type + "&page=1&number_per_page=<?php echo $number_per_page;?>";
}

</SCRIPT>
<div class="mwin" id="page">
    <div class="hd radius5tr clearfix">
        <h3>文章管理</h3>
    </div>
    <div class="bd">
        <p><a href="article_add.php">添加</a> <a onclick="batch_delete()" href="" name="batch_delete_link">删除</a> <a href="article.php?type=<?php echo $type; ?>&number_per_page=<?php echo $number_per_page;?>">刷新</a>  筛选 <select name="type" id="type" onchange="return filterType(document.getElementById('type').options[document.getElementById('type').selectedIndex].value);">
				<option value="0"<?php if($type==0) echo " selected"; ?>>全部</option>
				<option value="1"<?php if($type==1) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(1); ?></option>
				<option value="2"<?php if($type==2) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(2); ?></option>
				<option value="3"<?php if($type==3) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(3); ?></option>
				<option value="4"<?php if($type==4) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(4); ?></option>
				<option value="5"<?php if($type==5) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(5); ?></option>
				<option value="6"<?php if($type==6) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(6); ?></option>
				<option value="7"<?php if($type==7) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(7); ?></option>
				<option value="8"<?php if($type==8) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(8); ?></option>
				<option value="9"<?php if($type==9) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(9); ?></option>
				<option value="10"<?php if($type==10) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(10); ?></option>
				<option value="11"<?php if($type==11) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(11); ?></option>
				<option value="12"<?php if($type==12) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(12); ?></option>
				<option value="13"<?php if($type==13) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(13); ?></option>
				<option value="14"<?php if($type==14) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(14); ?></option>
				<option value="15"<?php if($type==15) echo " selected"; ?>><?php echo $config[DAOIMPL]->getArticleCateTypeDescription(15); ?></option>
						</select> 每页显示 << <?php if($number_per_page != 5) { ?><a href="article.php?type=<?php echo $type; ?>&number_per_page=5">5</a><?php } else { ?>5<?php } ?> <?php if($number_per_page != 10) { ?><a href="article.php?type=<?php echo $type; ?>&number_per_page=10">10</a><?php } else { ?>10<?php } ?> <?php if($number_per_page != 20) { ?><a href="article.php?type=<?php echo $type; ?>&number_per_page=20">20</a><?php } else { ?>20<?php } ?> <?php if($number_per_page != 30) { ?><a href="article.php?type=<?php echo $type; ?>&number_per_page=30">30</a><?php } else { ?>30<?php } ?> <?php if($number_per_page != 50) { ?><a href="article.php?type=<?php echo $type; ?>&number_per_page=50">50</a><?php } else { ?>50<?php } ?> >></p>
		<div class="grid radius5">
		    <table>
		        <colgroup>
		            <col width="42">
		            <col width="80">
					<col width="130">
					<col width="250">
		            <col>
		        </colgroup>
		        <thead>
		            <tr>
		                <th class="center"><input type="checkbox" name="selectAll" value="selectAll" onclick="ck()"></th>
						<th>类型</th>
						<th>时间</th>
						<th>主题</th>
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
						<td><?php echo $config[DAOIMPL]->getArticleCateTypeDescription($row["Cate"]); ?></td>
						<td><?php echo $row["AddTime"]; ?></td>
						<td><?php echo $row["Title"]; ?></td>
		                <td class="last"><a href="article_edit.php?id=<?php echo $row['id'];?>">编辑</a> <a href="article_delete.php?type=<?php echo $type; ?>&id=<?php echo $row['id'];?>&page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page; ?>">删除</a></td>
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
							<a href="article.php?type=<?php echo $type; ?>&page=<?php echo $current_page - 1;?>&number_per_page=<?php echo $number_per_page;?>">&lt;&lt;</a>
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
										<a href="article.php?type=<?php echo $type; ?>&page=<?php echo $i + 1; ?>&number_per_page=<?php echo $number_per_page;?>"><?php echo $i + 1;?></a>
							<?php
									}
								}
							?>
		                    <a href="article.php?type=<?php echo $type; ?>&page=<?php echo $current_page + 1;?>&number_per_page=<?php echo $number_per_page;?>">&gt;&gt;</a>  
		                </td>
		            </tr>
		        </tfoot>
		    </table>
		</div>
        
    </div>
</div>
