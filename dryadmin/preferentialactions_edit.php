<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'preferentialactions';

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
$pageTitle = '编辑优惠活动';
$pageDescription = '编辑优惠活动';
$pageKeywords = '编辑优惠活动';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'preferentialactions_edit';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";