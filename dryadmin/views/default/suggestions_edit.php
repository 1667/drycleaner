<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '修改会员建议信息成功';
$errorMsg = '';

if(!isset($_REQUEST["id"]) || $_REQUEST["id"] == '')
{
	echo '缺乏ID参数';
	exit();
}

$suggestion = $config[DAOIMPL]->getSuggestion($_REQUEST["id"]);

$user_id = 0;
$user_name = '';
if($suggestion['UserID'] > 0)
{
	$row_user = $config[DAOIMPL]->getUserEx($suggestion['UserID']);
	$user_name = $row_user['UserName'];
	$user_id = $row_user['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{	
	if($errorMsg == '')
	{
		//$config[DAOIMPL]->updateSuggestion($_POST["id"], array("HandleTime"=>$handleTime, "HandleResult"=>$handleResult, "Status"=>$handleStatus));
		//$suggestion = $config[DAOIMPL]->getSuggestion($_POST["id"]);
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="suggestions.php">建议管理</a> -> 编辑建议信息
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>编辑建议信息</h3>
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
		                <label>用户</label><?php if($user_id != 0) echo "<a href='users_view.php?id={$user_id}'>";?><?php echo $user_name; ?><?php if($user_id != 0) echo "</a>";?>
		            </div>
		            <div class="item">
		                <label>建议时间</label><?php echo $suggestion['SuggestionTime']; ?>
		            </div>
		            <div class="item">
		                <label>建议主题</label><?php echo $suggestion['Title']; ?>
		            </div>
		            <div class="item">
		                <label>建议内容</label><?php echo $suggestion['Content']; ?>
		            </div>
		            <div class="item">
		                <label>联系人</label><?php echo $suggestion['UserName']; ?>
		            </div>
		            <div class="item">
		                <label>联系方式</label><?php echo $suggestion['Contact']; ?>
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