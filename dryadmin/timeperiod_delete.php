<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'timeperiod';

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
$pageTitle = '删除时间段';
$pageDescription = '删除时间段';
$pageKeywords = '删除时间段';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'timeperiod_delete';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
?>