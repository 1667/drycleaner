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
$pageTitle = '删除当季特惠';
$pageDescription = '删除当季特惠';
$pageKeywords = '删除当季特惠';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'seasonpreferentials_delete';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
