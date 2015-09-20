<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '编辑类别成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$number_per_page = 10;
if(isset($_REQUEST['number_per_page']))
{
	$number_per_page = $_REQUEST['number_per_page'];
	if($number_per_page <= 0)
		$number_per_page = 10;
}
$current_page = 1;
if(isset($_REQUEST['page']))
{
	$current_page = $_REQUEST['page'];
	if($current_page <= 0)
		$current_page = 1;
}

$serviceType = $config[DAOIMPL]->getServiceType($_REQUEST["id"]);
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
	$typeName = '';
	$parentId = 0;
	$picFileName = '';
	
	if(!isset($_POST["name"]) || $_POST["name"] == '')
	{
		$errorMsg = $errorMsg . "名称不允许为空!<br>";
	}
	else
	{
		$typeName = $_POST['name'];
	}
	
	if(!isset($_POST["parentType"]) || $_POST["parentType"] == '')
	{
		$parentId = 0;
	}
	else
	{
		$parentId = $_POST["parentType"];
	}
	
    if (!is_uploaded_file($_FILES["picFileName"]["tmp_name"]))  
    {  
        $errorMsg = $errorMsg . "图片不存在!<br>";
    }
	else
	{
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
		$config[DAOIMPL]->updateServiceType($_POST["id"], array("ParentID"=>$parentId , "PicFileName"=>$picFileName, "TypeName"=>$typeName));
		$serviceType = $config[DAOIMPL]->getServiceType($_POST["id"]);
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="servicetypes.php?page=<?php echo $current_page; ?>&number_per_page=<?php echo $number_per_page;?>">类别管理</a> -> 编辑类别
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑衣物类别</h3>
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
					<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">
					<input type="hidden" name="page" value="<?php echo $current_page;?>">
					<input type="hidden" name="number_per_page" value="<?php echo $number_per_page;?>">
		            <div class="item">
		                <label>名称</label>
		                <input class="txt" type="text" name="name" value="<?php echo $serviceType["TypeName"]; ?>">
		            </div>
		            <div class="item">
		                <label>父类别</label>
						<select name="parentType">
							<option value="0"<?php if($serviceType["ParentID"] == 0) echo " selected"; ?>>顶级分类</option>
							<?php
								for($i = 0 ; $i < count($allTopTypes) ; $i++)
								{
							?>
									<option value="<?php echo $allTopTypes[$i]["id"]; ?>"<?php if($allTopTypes[$i]["id"]==$serviceType["ParentID"]) echo " selected"; ?>><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $allTopTypes[$i]["typeName"]; ?></option>
							<?php
									$subTypes = $config[DAOIMPL]->getSubServiceTypes($allTopTypes[$i]["id"]);
									for($j = 0 ; $j < count($subTypes) ; $j++)
									{
							?>
										<option value="<?php echo $subTypes[$j]["id"]; ?>"<?php if($subTypes[$j]["id"]==$serviceType["ParentID"]) echo " selected"; ?>><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $subTypes[$j]["typeName"]; ?></option>
							<?php
									}
								}
							?>
						</select>
		            </div>
		            <div class="item">
		                <label>图片</label>
						<input class="txt" name="picFileName" type="file"><br>
						<label></label>(<?=implode(', ',$uptypes)?>)
						<?php
						if($serviceType["PicFileName"] != '')
						{
						?>
							<label></label><a href="<?php echo $config[IMGURLDIR] . $serviceType["PicFileName"]; ?>" target=_blank><img src='<?php echo $config[IMGURLDIR] . $serviceType["PicFileName"]; ?>' width=50></a>
						<?php
						}
						?>
		            </div>
		            <div class="item">
		                <input type="submit" value="修 改">
		            </div>
				</fieldset>
		    </form>
		</div>
        <p>&nbsp;</p>
	</div>
</div>