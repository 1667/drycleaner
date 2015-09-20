<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '添加当季特惠成功';
$errorMsg = '';

$allTopTypes = $config[DAOIMPL]->getTopServiceTypes();

$TypeID = 0;
if(isset($_REQUEST['typeid']))
{
	$TypeID = $_REQUEST['typeid'];
	if($TypeID <= 0)
		$TypeID = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$goodsId = 0;
	
	if(!isset($_POST["goodsId"]) || $_POST["goodsId"] == '')
	{
		$errorMsg = $errorMsg . "产品ID号不允许为空!<br>";
	}
	else
	{
		$goodsId = $_POST['goodsId'];
		if(!$config[DAOIMPL]->goodsIsExist($goodsId))
		{
			$errorMsg = $errorMsg . "产品不存在!<br>";
		}
		else
		{
			if($config[DAOIMPL]->actionIsExist(1,$goodsId))
			{
				$errorMsg = $errorMsg . "该产品已经是当季特惠的产品了!<br>";
			}
		}
	}
	
	if($errorMsg == '')
	{
		$config[DAOIMPL]->addAction(array("Type"=>1 , "ClothingGoodsID"=>intval($goodsId)));
	}
}
////////////////////
?>

<SCRIPT LANGUAGE="JavaScript">
function filterGoodss(service_type)
{
	window.location = "<?php echo $config[ADMINBASEURL] . "seasonpreferentials_add.php?typeid="; ?>" + service_type;
}
</SCRIPT>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="seasonpreferentials.php">当季特惠</a> -> 添加当季特惠
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>添加当季特惠</h3>
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
		            <div class="item">
		                <label>产品类型</label>
						<select name="typeid" id="typeid" onchange="return filterGoodss(document.getElementById('typeid').options[document.getElementById('typeid').selectedIndex].value);">
							<?php
								for($i = 0 ; $i < count($allTopTypes) ; $i++)
								{
							?>
									<option value="<?php echo $allTopTypes[$i]["id"]; ?>"<?php if($TypeID == $allTopTypes[$i]["id"]) echo " selected";?>><?php echo $allTopTypes[$i]["typeName"]; ?></option>
							<?php
									$subTypes = $config[DAOIMPL]->getSubServiceTypes($allTopTypes[$i]["id"]);
									for($j = 0 ; $j < count($subTypes) ; $j++)
									{
							?>
										<option value="<?php echo $subTypes[$j]["id"]; ?>"<?php if($TypeID == $subTypes[$j]["id"]) echo " selected";?>><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $subTypes[$j]["typeName"]; ?></option>
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
								if($TypeID != 0)
								{
									$goods_count = $config[DAOIMPL]->getGoodsCountEx($TypeID);
									$goodss_rs = $config[DAOIMPL]->getGoodssEx(1,-1,$TypeID);
									for($i = 0 ; $i < $goods_count ; $i++)
									{
										$goods = mysql_fetch_array($goodss_rs);
							?>
										<option value="<?php echo $goods["id"]; ?>"><?php echo $goods["GoodsName"]; ?></option>
							<?php
									}
								}
							?>
						</select>
		            </div>
		            <div class="item">
						<label></label>
		                <input type="submit" value="添 加">
		            </div>
				</fieldset>
		    </form>
		</div>
        <p>&nbsp;</p>
	</div>
</div>