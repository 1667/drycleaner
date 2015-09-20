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
$pageTitle = '干洗小贴士管理';
$pageDescription = '干洗小贴士管理。';
$pageKeywords = '干洗小贴士管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'drytips';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
