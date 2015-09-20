<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'complains';

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
$pageTitle = '会员投诉管理';
$pageDescription = '会员投诉管理。';
$pageKeywords = '会员投诉管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'complains';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
