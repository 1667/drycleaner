<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'remands';

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
$pageTitle = '添加预约回送';
$pageDescription = '添加预约回送';
$pageKeywords = '添加预约回送';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'remands_add';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
