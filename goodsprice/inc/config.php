<?php
/**
 * config file
 * created by lane
 * @2012-01-01
*/
$config = array(
    SITENAME => '商品报价后台系统',
    VERSION => '1.0',

    PREKEY4PASSWORD => 'padm_',
    SUPERUSER => 'admin',
    SUPERUSERPASSWORD => 'phpwebadmin',

    DBDRIVER => array(
        DBHOST => 'rdsemjuqmemjuqm.mysql.rds.aliyuncs.com:3306',
        DBUSER => 'goodsprice_user',
        DBPASSWORD => 'Yunbiji888',
        DATABASE => 'goodsprice'
    ),
    TABLEPRE => array(
        FRONTEND => '',
        BACKEND => 'adm_',
    ),
    NEEDDB => true,
	ADMINBASEURL => "http://www.innke.com:8008/goodsprice/",
	DOMAIN => "http://www.innke.com:8008/",
	IMGURLDIR => "http://www.innke.com:8008/goodsprice/uploads",
);

//if (isset($needDb) && true == $needDb) {
    $config[NEEDDB] = true;
	//}
