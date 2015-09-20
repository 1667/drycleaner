<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'seasonpreferentials';

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
$pageTitle = '添加当季特惠';
$pageDescription = '添加当季特惠';
$pageKeywords = '添加当季特惠';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'seasonpreferentials_add';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
