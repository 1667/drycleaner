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
$pageTitle = '删除衣物产品';
$pageDescription = '删除衣物产品';
$pageKeywords = '删除衣物产品';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'clothinggoods_delete';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
