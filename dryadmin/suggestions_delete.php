<?php
/**
 * controller: demo
 * create by lane
 * @2012-01-02
 */
$pageName = 'suggestions';

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
$pageTitle = '删除会员建议';
$pageDescription = '删除会员建议';
$pageKeywords = '删除会员建议';

/**----------------
 * render views
 * layout and views
*/
$layoutName = 'main';
$viewGroup = 'default';
$viewName = 'suggestions_delete';

$layoutPath = "{$incPath}/views/layout/";
include_once "{$layoutPath}/{$layoutName}.php";
