<?php
/**
 * config file
 * created by lane
 * @2012-01-01
*/
$config = array(
    SITENAME => '威能后台系统',
    VERSION => '1.0',

    PREKEY4PASSWORD => 'padm_',
    SUPERUSER => 'admin',
    SUPERUSERPASSWORD => 'phpwebadmin',

    DBDRIVER => array(
        DBHOST => 'qdm-021.hichina.com:3306',
        DBUSER => 'qdm0210144',
        DBPASSWORD => 'sh112233',
        DATABASE => 'qdm0210144_db'
    ),
    TABLEPRE => array(
        FRONTEND => '',
        BACKEND => 'adm_',
    ),
    NEEDDB => true,
	ADMINBASEURL => "http://www.innke.com:8008/dryadmin/",
	DOMAIN => "http://www.innke.com:8008/",
	IMGURLDIR => "http://www.innke.com:8008/uploadimg/",
);

//if (isset($needDb) && true == $needDb) {
    $config[NEEDDB] = true;
	//}
