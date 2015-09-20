<?php
$incPath = dirname(__FILE__);
require_once "{$incPath}/../../inc/init.php";

$successMsg = '添加会员投诉成功';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
	$fromWhere = 3;
	$userName = '';
	$QQAccount = '';
	$weixinAccount = '';
	$weiboAccount = '';
	$alipayAccount = '';
	$loginPassword1 = '';
	$loginPassword2 = '';
	$payPassword1 = '';
	$payPassword2 = '';
	$sex = 1;
	$phoneNumber = '';
	$email = '';
	$trueName = '';
	$identifyNumber = '';
	$address = '';
	$birthday = '';
	$marryState = 1;
	$monthIncome = 1;
	$hobbies = '';
	$amount = 0.0;
	$points = 0;
	
	if(!isset($_POST["userName"]) || $_POST["userName"] == '')
	{
		$errorMsg = $errorMsg . "用户名不允许为空!<br>";
	}
	else
	{
		$userName = $_POST['userName'];
		if(!$config[DAOIMPL]->memberUserNameIsExist($userName))
		{
			$errorMsg = $errorMsg . "用户名已经存在!<br>";
		}
	}
	if(!isset($_POST["loginPassword1"]) || $_POST["loginPassword1"] == '')
	{
		$errorMsg = $errorMsg . "登录密码不允许为空!<br>";
	}
	else
	{
		$loginPassword1 = $_POST["loginPassword1"];
	}
	if(!isset($_POST["loginPassword2"]) || $_POST["loginPassword2"] == '')
	{
		$errorMsg = $errorMsg . "确认登录密码不允许为空!<br>";
	}
	else
	{
		$loginPassword2 = $_POST["loginPassword2"];
	}
	if(!isset($_POST["payPassword1"]) || $_POST["payPassword1"] == '')
	{
		$errorMsg = $errorMsg . "支付密码不允许为空!<br>";
	}
	else
	{
		$payPassword1 = $_POST["payPassword1"];
	}
	if(!isset($_POST["payPassword2"]) || $_POST["payPassword2"] == '')
	{
		$errorMsg = $errorMsg . "确认支付密码不允许为空!<br>";
	}
	else
	{
		$payPassword2 = $_POST["payPassword2"];
	}
	if(strcmp($loginPassword1,$loginPassword2) != 0)
	{
		$errorMsg = $errorMsg . "两次登录密码输入不一致!<br>";
	}
	else
	{
		$loginPassword1 = generateUserPassword($loginPassword1);
		$loginPassword2 = generateUserPassword($loginPassword2);
	}
	if(strcmp($payPassword1,$payPassword2) != 0)
	{
		$errorMsg = $errorMsg . "两次支付密码输入不一致!<br>";
	}
	else
	{
		$payPassword1 = generateUserPassword($payPassword1);
		$payPassword2 = generateUserPassword($payPassword2);
	}
	if(!isset($_POST["sex"]) || $_POST["sex"] == '')
	{
		$errorMsg = $errorMsg . "性别不允许为空!<br>";
	}
	else
	{
		$sex = intval($_POST["sex"]);
		if(!($sex >= 1 && $sex <= 3))
		{
			$errorMsg = $errorMsg . "性别参数有误!<br>";
		}
	}
	if(!isset($_POST["marryState"]) || $_POST["marryState"] == '')
	{
		$errorMsg = $errorMsg . "婚姻状况不允许为空!<br>";
	}
	else
	{
		$marryState = intval($_POST["marryState"]);
		if(!($marryState >= 1 && $marryState <= 3))
		{
			$errorMsg = $errorMsg . "婚姻状况参数有误!<br>";
		}
	}
	if(!isset($_POST["monthIncome"]) || $_POST["monthIncome"] == '')
	{
		$errorMsg = $errorMsg . "收入状况不允许为空!<br>";
	}
	else
	{
		$monthIncome = intval($_POST["monthIncome"]);
		if(!($monthIncome >= 1 && $marryState <= 5))
		{
			$errorMsg = $errorMsg . "收入状况参数有误!<br>";
		}
	}
	$QQAccount = $_POST["QQAccount"];
	$weixinAccount = $_POST["weixinAccount"];
	$weiboAccount = $_POST["weiboAccount"];
	$alipayAccount = $_POST["alipayAccount"];
	$phoneNumber = $_POST["phoneNumber"];
	$email = $_POST["email"];
	$trueName = $_POST["trueName"];
	$identifyNumber = $_POST["identifyNumber"];
	$address = $_POST["address"];
	$birthday = $_POST["birthday"];
	$amount = floatval($_POST["amount"]);
	$points = floatval($_POST["points"]);
	$hobbies = $_POST["hobbies"];
	
	if($errorMsg == '')
	{
		$config[DAOIMPL]->addMember(array("FromWhere"=>$fromWhere, "UserName"=>$userName, "QQAccount"=>$QQAccount, "WeixinAccount"=>$weixinAccount, "WeiboAccount"=>$weiboAccount, "AlipayAccount"=>$alipayAccount, "LoginPassword"=>$loginPassword1, "PayPassword"=>$payPassword1, "Sex"=>$sex, "PhoneNumber"=>$phoneNumber, "Email"=>$email, "TrueName"=>$trueName, "IdentifyNumber"=>$identifyNumber, "Address"=>$address, "Birthday"=>$birthday, "MarryState"=>$marryState, "MonthIncome"=>$monthIncome, "Hobbies"=>$hobbies, "Amount"=>$amount, "Points"=>$points));
	}
}
////////////////////
?>

<div class="mwin" id="page">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">首页</a> -> <a href="members.php">会员管理</a> -> 添加会员
	<br><br>
    <div class="hd radius5tr clearfix">
        <h3>添加会员</h3>
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
		                <label>会员名</label>
		                <input class="txt" type="text" name="userName" value="">
		            </div>
		            <div class="item">
		                <label>真实姓名</label>
		                <input class="txt" type="text" name="trueName" value="">
		            </div>
		            <div class="item">
		                <label>登录密码</label>
		                <input class="txt" type="text" name="loginPassword1" value="">
		            </div>
		            <div class="item">
		                <label>确认登录密码</label>
		                <input class="txt" type="text" name="loginPassword2" value="">
		            </div>
		            <div class="item">
		                <label>支付密码</label>
		                <input class="txt" type="text" name="payPassword1" value="">
		            </div>
		            <div class="item">
		                <label>支付登录密码</label>
		                <input class="txt" type="text" name="payPassword2" value="">
		            </div>
		            <div class="item">
		                <label>QQ账号</label>
		                <input class="txt" type="text" name="QQAccount" value="">
		            </div>
		            <div class="item">
		                <label>微信账号</label>
		                <input class="txt" type="text" name="weixinAccount" value="">
		            </div>
		            <div class="item">
		                <label>微博账号</label>
		                <input class="txt" type="text" name="weiboAccount" value="">
		            </div>
		            <div class="item">
		                <label>支付宝账号</label>
		                <input class="txt" type="text" name="alipayAccount" value="">
		            </div>
		            <div class="item">
		                <label>性别</label>
						<select name="sex" id="sex">
							<option value="1" selected><?php echo $config[DAOIMPL]->getMemberSexDescription(1); ?></option>
							<option value="2"><?php echo $config[DAOIMPL]->getMemberSexDescription(2); ?></option>
							<option value="3"><?php echo $config[DAOIMPL]->getMemberSexDescription(3); ?></option>
						</select>
		            </div>
		            <div class="item">
		                <label>电话号码</label>
		                <input class="txt" type="text" name="phoneNumber" value="">
		            </div>
		            <div class="item">
		                <label>邮箱</label>
		                <input class="txt" type="text" name="email" value="">
		            </div>
		            <div class="item">
		                <label>身份证号</label>
		                <input class="txt" type="text" name="identifyNumber" value="">
		            </div>
		            <div class="item">
		                <label>地址</label>
		                <input class="txt" type="text" name="address" value="">
		            </div>
		            <div class="item">
		                <label>生日</label>
		                <input class="txt" type="text" name="birthday" value="">
		            </div>
		            <div class="item">
		                <label>婚姻状况</label>
						<select name="marryState" id="marryState">
							<option value="1" selected><?php echo $config[DAOIMPL]->getMemberMarryDescription(1); ?></option>
							<option value="2"><?php echo $config[DAOIMPL]->getMemberMarryDescription(2); ?></option>
							<option value="3"><?php echo $config[DAOIMPL]->getMemberMarryDescription(3); ?></option>
						</select>
		            </div>
		            <div class="item">
		                <label>收入状况</label>
						<select name="monthIncome" id="monthIncome">
							<option value="1" selected><?php echo $config[DAOIMPL]->getMemberMonthIncomeDescription(1); ?></option>
							<option value="2"><?php echo $config[DAOIMPL]->getMemberMonthIncomeDescription(2); ?></option>
							<option value="3"><?php echo $config[DAOIMPL]->getMemberMonthIncomeDescription(3); ?></option>
							<option value="4"><?php echo $config[DAOIMPL]->getMemberMonthIncomeDescription(4); ?></option>
							<option value="5"><?php echo $config[DAOIMPL]->getMemberMonthIncomeDescription(5); ?></option>
						</select>
		            </div>
		            <div class="item">
		                <label>兴趣爱好</label>
		                <input class="txt" type="text" name="hobbies" value="">
		            </div>
		            <div class="item">
		                <label>账户余额</label>
		                <input class="txt" type="text" name="amount" value="">
		            </div>
		            <div class="item">
		                <label>积分余额</label>
		                <input class="txt" type="text" name="points" value="">
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