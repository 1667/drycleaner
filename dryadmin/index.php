<?php
/**
 * controller: default page
 * create by lane
 * @2012-01-01
 */
$pageName = 'index';

/**----------------
 * include common files
 */
$incPath = dirname(__FILE__);
require_once "{$incPath}/inc/init.php";


/**----------------
 * controll logical code here
 */


/**----------------
 * config title, description, keywords
*/
$pageTitle = '首页 -威能洗衣后台系统';
$pageDescription = '威能洗衣后台系统。';
$pageKeywords = '威能洗衣后台系统';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'index';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
