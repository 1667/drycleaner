<?php
/**
 * 系统菜单
 * 支持的group css类：pages, media, comments, settings
 * created by lane
 * @2012-01-01
 */
$supportGroupClasses = array('pages', 'media', 'comments', 'settings');
$extendArr = array('selected' => 'on', 'on' => '收起', 'off' => '展开');

//菜单自定义
$menus = array(
    'group_1' => array(
        'groupClass' => 'pages',
        'title' => '商品管理',
        'selected' => true,
        'items' => array(
            array('page' => 'servicetypes', 'text' => '类别管理', 'url' => 'servicetypes.php'),
			array('page' => 'clothinggoods', 'text' => '产品管理', 'url' => 'clothinggoods.php'),
			array('page' => 'seasonpreferentials', 'text' => '当季特惠', 'url' => 'seasonpreferentials.php'),
			array('page' => 'preferentialactions', 'text' => '优惠活动', 'url' => 'preferentialactions.php'),
        ),
    ),
    'group_2' => array(
        'groupClass' => 'media',
        'title' => '订单管理',
        'selected' => false,
        'items' => array(
            array('page' => 'orders', 'text' => '订单管理', 'url' => 'orders.php'),
			array('page' => 'remands', 'text' => '预约回送', 'url' => 'remands.php'),
			array('page' => 'evaluations', 'text' => '用户评价', 'url' => 'evaluations.php'),
        ),
    ),
    'group_3' => array(
        'groupClass' => 'comments',
        'title' => '会员管理',
        'selected' => false,
        'items' => array(
            array('page' => 'members', 'text' => '会员管理', 'url' => 'members.php'),
			array('page' => 'complains', 'text' => '会员投诉', 'url' => 'complains.php'),
			array('page' => 'suggestions', 'text' => '会员建议', 'url' => 'suggestions.php'),
        ),
    ),
    'group_4' => array(
        'groupClass' => 'comments',
        'title' => '内容管理',
        'selected' => false,
        'items' => array(
            array('page' => 'events', 'text' => '活动广告', 'url' => 'events.php'),
            array('page' => 'drytips', 'text' => '干洗小贴士', 'url' => 'drytips.php'),
        ),
    ),
);

//用户管理，只有超级用户才有权限
if ($_SESSION[SESSIONUSER] == $config[SUPERUSER]) {
    $menus['group_userlist'] = array(
        'groupClass' => 'settings',
        'title' => '系统设置',
        'selected' => false,
        'items' => array(
            array('page' => 'userlist', 'text' => '管理员列表', 'url' => 'user_list.php'),
            array('page' => 'useradd', 'text' => '添加管理员', 'url' => 'user_add.php'),
        )
    );
}

//group extend check
foreach ($menus as $key => $group) {
    foreach ($group['items'] as $item) {
        if ($pageName == $item['page']) {
            $menus[$key]['selected'] = true;
            break;
        }
    }
}
