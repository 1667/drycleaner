<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'servicetypes';

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
$pageTitle = '服务类型管理';
$pageDescription = '服务类型管理。';
$pageKeywords = '服务类型管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'servicetypes';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
