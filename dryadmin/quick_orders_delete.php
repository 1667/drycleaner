<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'quick_orders';

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
$pageTitle = '删除快捷订单';
$pageDescription = '删除快捷订单';
$pageKeywords = '删除快捷订单';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'quick_orders_delete';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
