<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '编辑当季特惠成功';
$errorMsg = '';

$allTopTypes = $config[DAOIMPL]->getTopServiceTypes();

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$TypeID = 0;
if(isset($_REQUEST['typeid']))
{
	$TypeID = $_REQUEST['typeid'];
	if($TypeID <= 0)
		$TypeID = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$goods_id = 0;
	if(isset($_REQUEST['goodsId']))
	{
		$goods_id = $_REQUEST['goodsId'];
		if($goods_id <= 0)
		{
			echo '缺乏商品ID参数';
			exit();
		}
	}
	else
	{
		echo '缺乏商品ID参数';
		exit();
	}
	$config[DAOIMPL]->updateAction($_REQUEST["id"], array("ClothingGoodsID"=>$goods_id));
	
	$action = $config[DAOIMPL]->getAction($_REQUEST["id"]);

	$goods_name = '';
	$goods_id = 0;
	if($action['ClothingGoodsID'] > 0)
	{
		$row_goods = $config[DAOIMPL]->getGoods($action['ClothingGoodsID']);
		$goods_name = $row_goods['GoodsName'];
		$goods_id = $row_goods['id'];
		$goods_type_id = $row_goods['ServiceTypeID'];
	}
}
else
{
	$action = $config[DAOIMPL]->getAction($_REQUEST["id"]);

	$goods_name = '';
	$goods_id = 0;
	if($action['ClothingGoodsID'] > 0)
	{
		$row_goods = $config[DAOIMPL]->getGoods($action['ClothingGoodsID']);
		$goods_name = $row_goods['GoodsName'];
		$goods_id = $row_goods['id'];
		$goods_type_id = $row_goods['ServiceTypeID'];
	}
}
////////////////////
?>

<SCRIPT LANGUAGE="JavaScript">
function filterGoodss(service_type)
{
	window.location = "<?php echo $config[ADMINBASEURL] . "seasonpreferentials_edit.php?id=" . $_REQUEST["id"] . "&typeid="; ?>" + service_type;
}
</SCRIPT>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="seasonpreferentials.php">当季特惠</a> -> 编辑当季特惠
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑当季特惠</h3>
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
		                <label>产品类型</label>
						<select name="typeid" id="typeid" onchange="return filterGoodss(document.getElementById('typeid').options[document.getElementById('typeid').selectedIndex].value);">
							<?php
								for($i = 0 ; $i < count($allTopTypes) ; $i++)
								{
							?>
									<option value="<?php echo $allTopTypes[$i]["id"]; ?>"<?php if($TypeID>0) {  if($TypeID == $allTopTypes[$i]["id"]) echo " selected";  } else { if($goods_type_id == $allTopTypes[$i]["id"]) echo " selected"; }?>><?php echo $allTopTypes[$i]["typeName"]; ?></option>
							<?php
									$subTypes = $config[DAOIMPL]->getSubServiceTypes($allTopTypes[$i]["id"]);
									for($j = 0 ; $j < count($subTypes) ; $j++)
									{
							?>
										<option value="<?php echo $subTypes[$j]["id"]; ?>"<?php if($TypeID>0) { if($TypeID == $subTypes[$j]["id"]) echo " selected"; } else { if($goods_type_id == $subTypes[$j]["id"]) echo " selected"; } ?>><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $subTypes[$j]["typeName"]; ?></option>
							<?php
									}
								}
							?>
						</select>
		            </div>
		            <div class="item">
		                <label>产品名称</label>
						<select name="goodsId">
							<?php
							if($TypeID>0)
							{
								$goods_count = $config[DAOIMPL]->getGoodsCountEx($TypeID);
								$goodss_rs = $config[DAOIMPL]->getGoodssEx(1,-1,$TypeID);
								for($i = 0 ; $i < $goods_count ; $i++)
								{
									$goods = mysql_fetch_array($goodss_rs);
							?>
									<option value="<?php echo $goods["id"]; ?>"<?php if($goods["id"] == $goods_id) echo " selected"?>><?php echo $goods["GoodsName"]; ?></option>
							<?php
								}
							}
							else
							{
								if($goods_type_id != 0)
								{
									$goods_count = $config[DAOIMPL]->getGoodsCountEx($goods_type_id);
									$goodss_rs = $config[DAOIMPL]->getGoodssEx(1,-1,$goods_type_id);
									for($i = 0 ; $i < $goods_count ; $i++)
									{
										$goods = mysql_fetch_array($goodss_rs);
							?>
										<option value="<?php echo $goods["id"]; ?>"<?php if($goods["id"] == $goods_id) echo " selected"?>><?php echo $goods["GoodsName"]; ?></option>
							<?php
									}
								}
							}
							?>
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