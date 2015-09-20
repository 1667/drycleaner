<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '修改文章成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$article = $config[DAOIMPL]->getArticle($_REQUEST["id"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$title = '';
	$add_time = date("Y-m-d H:i:s", time());
	$content = '';
	$type = 0;
	
	if(!isset($_POST["type"]) || $_POST["type"] == '')
	{
		$errorMsg = $errorMsg . "类型不允许为空!<br>";
	}
	else
	{
		$type = intval($_POST['type']);
	}
	if(!isset($_POST["title"]) || $_POST["title"] == '')
	{
		$errorMsg = $errorMsg . "主题不允许为空!<br>";
	}
	else
	{
		$title = $_POST['title'];
	}
	
	if(!isset($_POST["content"]) || $_POST["content"] == '')
	{
		$errorMsg = $errorMsg . "内容不允许为空!<br>";
	}
	else
	{
		$content = $_POST['content'];
	}
	
	if($errorMsg == '')
	{
		$config[DAOIMPL]->updateArticle($_POST["id"], array("Title"=>$title, "AddTime"=>$add_time, "Content"=>$content, "Cate"=>$type));
		$article = $config[DAOIMPL]->getArticle($_POST["id"]);
	}
}
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="article.php">文章管理</a> -> 编辑文章
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑文章</h3>
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
		                <label>类型</label>
						<select name="type">
							<?php
								$types = $config[DAOIMPL]->getArticleTypes();
								foreach($types as $key => $value)
								{
							?>
									<option value="<?php echo $key; ?>"<?php if($key == $article['Cate']) echo ' selected'?>><?php echo $value; ?></option>
							<?php
								}
							?>
						</select>
		            </div>
					
		            <div class="item">
		                <label>主题</label>
		                <input class="txt" type="text" name="title" value="<?php echo $article['Title']; ?>">
		            </div>
		            <div class="item">
		                <label>内容</label>
						<textarea class="ckeditor" cols="50" id="content" name="content" rows="10"><?php echo $article['Content']; ?>
						</textarea>
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