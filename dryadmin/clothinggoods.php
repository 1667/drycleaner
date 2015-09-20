<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'clothinggoods';

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
$pageTitle = '衣物产品管理';
$pageDescription = '衣物产品管理。';
$pageKeywords = '衣物产品管理';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'clothinggoods';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
