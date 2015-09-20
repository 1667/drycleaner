<?php
$incPath = dirname(__FILE__);

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

$max_file_size = 200000000;     //上传文件大小限制, 单位BYTE  
$destination_folder = "{$incPath}/uploads/"; //上传文件路径  
$watermark = 0;      //是否附加水印(1为加水印,其他为不加水印);  
$watertype = 1;      //水印类型(1为文字,2为图片)  
$waterposition = 1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
$waterstring = "";  //水印字符串  
$waterimg = "xplore.gif";    //水印图片  
$imgpreview = 0;      //是否生成预览图(1为生成,其他为不生成);  
$imgpreviewsize = 1/2;    //缩略图比例
///////////////////////////////////////////////

$picFileName = '';
$ApiType = "UploadPic";
$Result = -1;
$ErrDescription = '';

if (!is_uploaded_file($_FILES["picFileName"]["tmp_name"]))  
{  
    $ErrDescription = $ErrDescription . "图片不存在!<br>";
}

if($ErrDescription == '')
{
    $file = $_FILES["picFileName"];
	$filename = $file["tmp_name"];
    if($max_file_size < $file["size"])  
    {
        $ErrDescription = $ErrDescription . "文件太大!<br>"; 
    }
    else
	{
	    /*if(!in_array($file["type"], $uptypes))
	    {
			$ErrDescription = $ErrDescription . "文件类型不符!<br>";
	    }  
	  	else*/
		{
		    if(!file_exists($destination_folder))
		    {  
		        mkdir($destination_folder);  
		    }  
		    $image_size = getimagesize($filename);  
		    $pinfo = pathinfo($file["name"]);  
		    $ftype = $pinfo['extension'];
			$now_time = time();
		    $destination = $destination_folder.$now_time.".".$ftype;
			$picFileName = $now_time.".".$ftype;
		    if (file_exists($destination) && $overwrite != true)  
		    {
				$ErrDescription = $ErrDescription . "同名文件已经存在了!<br>";
		    }
			else
			{
			    if(!move_uploaded_file ($filename, $destination))  
			    {
					$ErrDescription = $ErrDescription . "移动文件出错!<br>";  
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

if($ErrDescription == '')
{
	$Result = 0;
}

echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "FileName"=>$picFileName));

?>