<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '添加产品成功';
$errorMsg = '';

$allTopTypes = $config[DAOIMPL]->getTopServiceTypes();

///////////////////////////////////////////////
// 上传图片文件设置
//上传文件类型列表  
$uptypes=array(  
    'image/jpg',  
    'image/jpeg',  
    'image/png',  
    'image/pjpeg',  
    'image/gif',  
    'image/bmp',  
    'image/x-png'  
);  

$max_file_size = 2000000;     //上传文件大小限制, 单位BYTE  
$destination_folder = "{$incPath}/../../../uploadimg/"; //上传文件路径  
$watermark = 0;      //是否附加水印(1为加水印,其他为不加水印);  
$watertype = 1;      //水印类型(1为文字,2为图片)  
$waterposition = 1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
$waterstring = "http://www.innke.com:8008/";  //水印字符串  
$waterimg = "xplore.gif";    //水印图片  
$imgpreview = 0;      //是否生成预览图(1为生成,其他为不生成);  
$imgpreviewsize = 1/2;    //缩略图比例
///////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$typeId = 0;
	$picFileName = '';
	$goodsName = '';
	$sourcePrice = 0.0;
	$currentPrice = 0.0;
	$serviceMode = 63;
	$wrapMode = '';
	$distributionMode = '';
	$materialQuality = 0;
	$style = 0;
	$dryDescription = '';
	
	if(!isset($_POST["name"]) || $_POST["name"] == '')
	{
		$errorMsg = $errorMsg . "名称不允许为空!<br>";
	}
	else
	{
		$goodsName = $_POST['name'];
	}
	
	if(!isset($_POST["typeId"]) || $_POST["typeId"] == '')
	{
		$errorMsg = $errorMsg . "产品类别不允许为空!<br>";
	}
	else
	{
		if(intval($_POST["typeId"]) == 0)
		{
			$errorMsg = $errorMsg . "产品类别不允许为空!<br>";
		}
		else
		{
			$typeId = $_POST["typeId"];
		}
	}
	
	if(!isset($_POST["currentPrice"]) || $_POST["currentPrice"] == '')
	{
		$errorMsg = $errorMsg . "当前价格不允许为空!<br>";
	}
	else
	{
		$currentPrice = floatval($_POST["currentPrice"]);
	}
	
    if (!is_uploaded_file($_FILES["picFileName"]["tmp_name"]))  
    {  
        $errorMsg = $errorMsg . "图片不存在!<br>";
    }
	
	if($errorMsg == '')
	{
		$sourcePrice = (!isset($_POST["sourcePrice"]) || $_POST["sourcePrice"] == '') ? 0.0 : floatval($_POST["sourcePrice"]);
		$wrapMode = $_POST["wrapMode"];
		$distributionMode = $_POST["distributionMode"];
		$dryDescription = $_POST["dryDescription"];
		$serviceMode = 0;
		for($i = 0 ; $i < count($_POST["serviceMode"]) ; $i++)
		{
			$serviceMode |= $_POST["serviceMode"][$i];
		}
		$materialQuality = 0;
		for($i = 0 ; $i < count($_POST["materialQuality"]) ; $i++)
		{
			$materialQuality |= $_POST["materialQuality"][$i];
		}
		$style = 0;
		for($i = 0 ; $i < count($_POST["style"]) ; $i++)
		{
			$style |= $_POST["style"][$i];
		}
		
	    $file = $_FILES["picFileName"];
	    if($max_file_size < $file["size"])  
	    {  
	        $errorMsg = $errorMsg . "文件太大!<br>"; 
	    }
 	    else
		{
		    if(!in_array($file["type"], $uptypes))
		    {
				$errorMsg = $errorMsg . "文件类型不符!<br>";
		    }  
  		  	else
			{
			    if(!file_exists($destination_folder))  
			    {  
			        mkdir($destination_folder);  
			    }
  
			    $filename = $file["tmp_name"];  
			    $image_size = getimagesize($filename);  
			    $pinfo = pathinfo($file["name"]);  
			    $ftype = $pinfo['extension'];
				$now_time = time();
			    $destination = $destination_folder.$now_time.".".$ftype;
				$picFileName = $now_time.".".$ftype;
			    if (file_exists($destination) && $overwrite != true)  
			    {
					$errorMsg = $errorMsg . "同名文件已经存在了!<br>";
			    }
				else
				{
				    if(!move_uploaded_file ($filename, $destination))  
				    {
						$errorMsg = $errorMsg . "移动文件出错!<br>";  
				    }
					else
					{					
					    $pinfo = pathinfo($destination);  
					    $fname = $pinfo[basename];
  
					    if($watermark == 1)
					    {  
					        $iinfo = getimagesize($destination,$iinfo);  
					        $nimage = imagecreatetruecolor($image_size[0],$image_size[1]);  
					        $white = imagecolorallocate($nimage,255,255,255);  
					        $black = imagecolorallocate($nimage,0,0,0);  
					        $red = imagecolorallocate($nimage,255,0,0);  
					        imagefill($nimage,0,0,$white);  
					        switch ($iinfo[2])  
					        {  
					            case 1:  
					            	$simage =imagecreatefromgif($destination);  
					            	break;  
					            case 2:  
					            	$simage =imagecreatefromjpeg($destination);  
					            	break;  
					            case 3:  
					            	$simage =imagecreatefrompng($destination);  
					            	break;  
					            case 6:  
					            	$simage =imagecreatefromwbmp($destination);  
					            	break;  
					            default:  
					            	die("不支持的文件类型");  
					            	exit;  
					        }  
  
					        imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);  
					        imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);  
  
					        switch($watertype)  
					        {  
					            case 1:   //加水印字符串  
					            	imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);  
					            	break;  
					            case 2:   //加水印图片  
					            	$simage1 =imagecreatefromgif("xplore.gif");  
					            	imagecopy($nimage,$simage1,0,0,0,0,85,15);  
					            	imagedestroy($simage1);  
					            	break;  
					        }  
  
					        switch ($iinfo[2])  
					        {  
					            case 1:  
					            	imagejpeg($nimage, $destination);  
					            	break;  
					            case 2:  
					            	imagejpeg($nimage, $destination);  
					            	break;  
					            case 3:  
					            	imagepng($nimage, $destination);  
					            	break;  
					            case 6:  
					            	imagewbmp($nimage, $destination);  
					            	break;  
					        }  
  
					        //覆盖原上传文件  
					        imagedestroy($nimage);  
					        imagedestroy($simage);  
					    }
					}
				}
			}
		}
	}
	if($errorMsg == '')
	{
		$config[DAOIMPL]->addGoods(array("ServiceTypeID"=>$typeId , "PicFileName"=>$picFileName, "GoodsName"=>$goodsName, "SourcePrice"=>$sourcePrice, "CurrentPrice"=>$currentPrice, "ServiceMode"=>$serviceMode, "WrapMode"=>$wrapMode, "DistributionMode"=>$distributionMode, "MaterialQuality"=>$materialQuality, "Style"=>$style, "DryDescription"=>$dryDescription));
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="clothinggoods.php">产品管理</a> -> 添加产品
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>添加衣物产品</h3>
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
		    <form action="?" method="POST" enctype="multipart/form-data" >
		        <fieldset class="radius5">
		            <div class="item">
		                <label>名称</label>
		                <input class="txt" type="text" name="name" value="<?php if(isset($_REQUEST["name"])) echo $_REQUEST["name"];?>">
		            </div>
		            <div class="item">
		                <label>类别</label>
						<select name="typeId">
							<?php
								for($i = 0 ; $i < count($allTopTypes) ; $i++)
								{
							?>
									<option value="<?php echo $allTopTypes[$i]["id"]; ?>"<?php if(isset($_REQUEST["typeId"]) && ($_REQUEST["typeId"] == $allTopTypes[$i]["id"])) echo " selected";?>><?php echo $allTopTypes[$i]["typeName"]; ?></option>
							<?php
									$subTypes = $config[DAOIMPL]->getSubServiceTypes($allTopTypes[$i]["id"]);
									for($j = 0 ; $j < count($subTypes) ; $j++)
									{
							?>
										<option value="<?php echo $subTypes[$j]["id"]; ?>"<?php if(isset($_REQUEST["typeId"]) && ($_REQUEST["typeId"] == $subTypes[$j]["id"])) echo " selected";?>><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $subTypes[$j]["typeName"]; ?></option>
							<?php
									}
								}
							?>
						</select>
		            </div>
		            <div class="item">
		                <label>图片</label><input class="txt" name="picFileName" type="file"><br>
						<label></label>(<?=implode(', ',$uptypes)?>)
		            </div>
		            <div class="item">
		                <label>原价</label>
		                <input class="txt" type="text" name="sourcePrice" value="<?php if(isset($_REQUEST["sourcePrice"])) echo $_REQUEST["sourcePrice"]; else echo "0.0";?>">
		            </div>
		            <div class="item">
		                <label>现价</label>
		                <input class="txt" type="text" name="currentPrice" value="<?php if(isset($_REQUEST["currentPrice"])) echo $_REQUEST["currentPrice"]; else echo "0.0";?>">
		            </div>
		            <div class="item">
		                <label>服务</label><input name="serviceMode[]" type="checkbox" id="serviceMode[]" value="1"<?php if(isset($_REQUEST["serviceMode"])) { for($i = 0 ; $i < count($_REQUEST["serviceMode"]) ; $i++) { if(intval($_REQUEST["serviceMode"][$i]) == 1) echo " checked"; } }?>/> 上门收件<br>
						<label></label><input name="serviceMode[]" type="checkbox" id="serviceMode[]" value="2"<?php if(isset($_REQUEST["serviceMode"])) { for($i = 0 ; $i < count($_REQUEST["serviceMode"]) ; $i++) { if(intval($_REQUEST["serviceMode"][$i]) == 2) echo " checked"; } }?>/> 洗护<br>
						<label></label><input name="serviceMode[]" type="checkbox" id="serviceMode[]" value="4"<?php if(isset($_REQUEST["serviceMode"])) { for($i = 0 ; $i < count($_REQUEST["serviceMode"]) ; $i++) { if(intval($_REQUEST["serviceMode"][$i]) == 4) echo " checked"; } }?>/> 熨烫<br>
						<label></label><input name="serviceMode[]" type="checkbox" id="serviceMode[]" value="8"<?php if(isset($_REQUEST["serviceMode"])) { for($i = 0 ; $i < count($_REQUEST["serviceMode"]) ; $i++) { if(intval($_REQUEST["serviceMode"][$i]) == 8) echo " checked"; } }?>/> 消毒<br>
						<label></label><input name="serviceMode[]" type="checkbox" id="serviceMode[]" value="16"<?php if(isset($_REQUEST["serviceMode"])) { for($i = 0 ; $i < count($_REQUEST["serviceMode"]) ; $i++) { if(intval($_REQUEST["serviceMode"][$i]) == 16) echo " checked"; } }?>/> 包装<br>
						<label></label><input name="serviceMode[]" type="checkbox" id="serviceMode[]" value="32"<?php if(isset($_REQUEST["serviceMode"])) { for($i = 0 ; $i < count($_REQUEST["serviceMode"]) ; $i++) { if(intval($_REQUEST["serviceMode"][$i]) == 32) echo " checked"; } }?>/> 送回<br>
		            </div>
		            <div class="item">
		                <label>包装方式</label>
		                <input class="txt" type="text" name="wrapMode" value="<?php if(isset($_REQUEST["wrapMode"])) echo $_REQUEST["wrapMode"]; else echo "防尘PVC";?>">
		            </div>
		            <div class="item">
		                <label>配送方式</label>
		                <input class="txt" type="text" name="distributionMode" value="<?php if(isset($_REQUEST["wrapMode"])) echo $_REQUEST["distributionMode"]; else echo "威能快递";?>">
		            </div>
		            <div class="item">
		                <label>材质</label><input name="materialQuality[]" type="checkbox" id="materialQuality[]" value="1"<?php if(isset($_REQUEST["materialQuality"])) { for($i = 0 ; $i < count($_REQUEST["materialQuality"]) ; $i++) { if(intval($_REQUEST["materialQuality"][$i]) == 1) echo " checked"; } }?>/> 棉<br>
						<label></label><input name="materialQuality[]" type="checkbox" id="materialQuality[]" value="2"<?php if(isset($_REQUEST["materialQuality"])) { for($i = 0 ; $i < count($_REQUEST["materialQuality"]) ; $i++) { if(intval($_REQUEST["materialQuality"][$i]) == 2) echo " checked"; } }?>/> 亚麻<br>
						<label></label><input name="materialQuality[]" type="checkbox" id="materialQuality[]" value="4"<?php if(isset($_REQUEST["materialQuality"])) { for($i = 0 ; $i < count($_REQUEST["materialQuality"]) ; $i++) { if(intval($_REQUEST["materialQuality"][$i]) == 4) echo " checked"; } }?>/> 羊毛/羊绒<br>
						<label></label><input name="materialQuality[]" type="checkbox" id="materialQuality[]" value="8"<?php if(isset($_REQUEST["materialQuality"])) { for($i = 0 ; $i < count($_REQUEST["materialQuality"]) ; $i++) { if(intval($_REQUEST["materialQuality"][$i]) == 8) echo " checked"; } }?>/> 皮革/皮草<br>
						<label></label><input name="materialQuality[]" type="checkbox" id="materialQuality[]" value="16"<?php if(isset($_REQUEST["materialQuality"])) { for($i = 0 ; $i < count($_REQUEST["materialQuality"]) ; $i++) { if(intval($_REQUEST["materialQuality"][$i]) == 16) echo " checked"; } }?>/> 混纺<br>
						<label></label><input name="materialQuality[]" type="checkbox" id="materialQuality[]" value="32"<?php if(isset($_REQUEST["materialQuality"])) { for($i = 0 ; $i < count($_REQUEST["materialQuality"]) ; $i++) { if(intval($_REQUEST["materialQuality"][$i]) == 32) echo " checked"; } }?>/> 人造纤维/化学纤维<br>
		            </div>
		            <div class="item">
		                <label>款型</label><input name="style[]" type="checkbox" id="style[]" value="1"<?php if(isset($_REQUEST["style"])) { for($i = 0 ; $i < count($_REQUEST["style"]) ; $i++) { if(intval($_REQUEST["style"][$i]) == 1) echo " checked"; } }?>/> 常规款<br>
						<label></label><input name="style[]" type="checkbox" id="style[]" value="2"<?php if(isset($_REQUEST["style"])) { for($i = 0 ; $i < count($_REQUEST["style"]) ; $i++) { if(intval($_REQUEST["style"][$i]) == 2) echo " checked"; } }?>/> 短款<br>
						<label></label><input name="style[]" type="checkbox" id="style[]" value="4"<?php if(isset($_REQUEST["style"])) { for($i = 0 ; $i < count($_REQUEST["style"]) ; $i++) { if(intval($_REQUEST["style"][$i]) == 4) echo " checked"; } }?>/> 中款<br>
						<label></label><input name="style[]" type="checkbox" id="style[]" value="8"<?php if(isset($_REQUEST["style"])) { for($i = 0 ; $i < count($_REQUEST["style"]) ; $i++) { if(intval($_REQUEST["style"][$i]) == 8) echo " checked"; } }?>/> 长款<br>
						<label></label><input name="style[]" type="checkbox" id="style[]" value="16"<?php if(isset($_REQUEST["style"])) { for($i = 0 ; $i < count($_REQUEST["style"]) ; $i++) { if(intval($_REQUEST["style"][$i]) == 16) echo " checked"; } }?>/> 短袖<br>
						<label></label><input name="style[]" type="checkbox" id="style[]" value="32"<?php if(isset($_REQUEST["style"])) { for($i = 0 ; $i < count($_REQUEST["style"]) ; $i++) { if(intval($_REQUEST["style"][$i]) == 32) echo " checked"; } }?>/> 长袖<br>
		            </div>
		            <div class="item">
		                <label>干洗介绍</label><textarea class="ckeditor" cols="50" id="content" name="dryDescription" rows="8"><?php if(isset($_REQUEST["dryDescription"])) echo $_REQUEST["dryDescription"];?></textarea>
		            </div>
		            <div class="item">
		                <label></label><input type="submit" value="添 加">
		            </div>
				</fieldset>
		    </form>
		</div>
        <p>&nbsp;</p>
	</div>
</div>