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
$pageTitle = '当季特惠管理';
$pageDescription = '当季特惠管理。';
$pageKeywords = '当季特惠管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'seasonpreferentials';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
