<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'preferentialactions';

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
$pageTitle = '优惠活动管理';
$pageDescription = '优惠活动管理。';
$pageKeywords = '优惠活动管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'preferentialactions';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
