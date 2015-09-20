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
$pageTitle = '添加衣物分类';
$pageDescription = '添加衣物分类';
$pageKeywords = '添加衣物分类';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'servicetypes_add';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
