<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'orders';

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
$pageTitle = '添加订单';
$pageDescription = '添加订单';
$pageKeywords = '添加订单';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'orders_add';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
