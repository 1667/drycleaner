<?php
	$incPath = dirname(__FILE__);
	
	require_once "{$incPath}/inc/init_api.php";
	
	$bCheckSuccess = true;
	
	if(!isset($_REQUEST["id"]))
	{
		$bCheckSuccess = false;
		$ErrDescription = "参数错误";
	}

	if($bCheckSuccess)
	{
		$arr_record = $config[DAOIMPL]->getGoodsPrice(intval($_REQUEST["id"]));
		
		if(count($arr_record) > 0)
		{
			$arr_record["view_count"] = $arr_record["view_count"] + 1;
			$config[DAOIMPL]->updateGoodsPrice($_REQUEST["id"], array("view_count"=>$arr_record["view_count"]));
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title><?php echo $arr_record["title"]; ?></title>
		<style type="text/css"> 
		body{ font-size:16px; line-height:24px;} 
		.title{font-size:50px;font-weight:bold;} 
		.description{font-size:45px;} 
		.view_count{font-size:15px;} 
		.create_time{font-size:15px;}
		</style>
	</head>
	<body>
		<table width=100% align=center>
			<tr>
				<td align=center class="title">
					<span class="title"><?php echo $arr_record["title"]; ?></span>
				</td>
			</tr>
			<tr>
				<td align=left class="description">
					<span class="description"><?php echo $arr_record["description"]; ?></span>
				</td>
			</tr>
			<?php
			for($i = 1 ; $i <= $arr_record["pic_count"] ; $i++)
			{
			?>
			<tr>
				<td align=center>
					<img src=<?php echo "uploads/" . $arr_record["picFile_{$i}"]; ?>>
				</td>
			</tr>
			<?php	
			}
			?>
		</table>
	</body>
</html>
<?php
		}
		else
		{
			$bCheckSuccess = false;
			$ErrDescription = "无此商品报价";
		}
	}
	if(!$bCheckSuccess)
	{
		echo $ErrDescription;
	}
?>