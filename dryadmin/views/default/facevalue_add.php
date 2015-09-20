<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '添加充值方式成功';
$errorMsg = '';

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
	$title = '';
	$infund = 0;
	$give_fund = 0;
	
	if(!isset($_POST["title"]) || $_POST["title"] == '')
	{
		$errorMsg = $errorMsg . "充值方式不允许为空!<br>";
	}
	else
	{
		$title = $_POST['title'];
	}
	if(!isset($_POST["infund"]) || $_POST["infund"] == '')
	{
		$errorMsg = $errorMsg . "充值金额不允许为空!<br>";
	}
	else
	{
		$infund = $_POST["infund"];
	}
	if(!isset($_POST["give_fund"]) || $_POST["give_fund"] == '')
	{
		$errorMsg = $errorMsg . "赠送金额不允许为空!<br>";
	}
	else
	{
		$give_fund = $_POST["give_fund"];
	}
	
   
	if($errorMsg == '')
	{
		$config[DAOIMPL]->addFacevalue(array("Title"=>$title, "infund"=>$infund, "give_fund"=>$give_fund));
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="facevalue.php">面值管理</a> -> 添加充值方式
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>添加充值方式</h3>
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
		    <form action="?" method="POST" enctype="multipart/form-data">
		        <fieldset class="radius5">
		            <div class="item">
		                <label>活动主题</label>
		                <input class="txt" type="text" name="title" value="">
		            </div>
		            <div class="item">
		                <label>充值金额</label>
		                <input class="txt" type="value" name="infund" value="">
		            </div>
		            <div class="item">
		                <label>赠送金额</label>
		                <input class="txt" type="value" name="give_fund" value="">
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