<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'evaluations';

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
$pageTitle = '编辑用户评价';
$pageDescription = '编辑用户评价';
$pageKeywords = '编辑用户评价';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'evaluations_edit';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
