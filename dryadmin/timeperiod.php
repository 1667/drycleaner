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
$pageTitle = '时间段管理';
$pageDescription = '时间段管理。';
$pageKeywords = '时间段管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'timeperiod';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
?>