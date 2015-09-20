<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'drytips';

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
$pageTitle = '添加干洗小贴士';
$pageDescription = '添加干洗小贴士';
$pageKeywords = '添加干洗小贴士';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'drytips_add';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
