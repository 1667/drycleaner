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
$pageTitle = '预约回送管理';
$pageDescription = '预约回送管理。';
$pageKeywords = '预约回送管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'remands';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
