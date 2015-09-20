<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'events';

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
$pageTitle = '添加活动广告';
$pageDescription = '添加活动广告';
$pageKeywords = '添加活动广告';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'events_add';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
