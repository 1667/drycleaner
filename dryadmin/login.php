<?php
/**
 * controller: login page
 * create by lane
 * @2012-01-01
 */
$pageName = 'login';
$needDb = true; //enable db

/**----------------
 * include common files
 */
$incPath = dirname(__FILE__);
require_once "{$incPath}/inc/init.php";


/**----------------
 * controll logical code here
 */
//user login
if (isset($_POST['username']) && isset($_POST['password'])
    && !empty($_POST['username']) && !empty($_POST['password'])
) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rs = $config[DAOIMPL]->getUserByName($username);
    $arr = mysql_fetch_array($rs);
    if ($arr && $arr['password'] == generateUserPassword($password)) {
        $_SESSION[SESSIONUSER] = $username;
        header("Location: index.php");
        exit(0);
    }else {
        $errorMsg = '请检查用户名和密码是否输入正确！';
    }
}

/**----------------
 * config title, description, keywords
*/
$pageTitle = '威能洗衣';
$pageDescription = '威能洗衣后台管理';
$pageKeywords = '威能洗衣后台管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'login';
$viewGroup = 'login';
$viewName = 'index';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
