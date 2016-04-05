<?php
return array(
	'compName'=> '有限公司',
	'ENcompName'=> 'Technologies.Inc',
	'menu'=>'Config/menu.php',//使用的菜单目录
	'khqcxs'=>true,//列表和搜索项中是否显示客户全称
	'htbmgz'=>'getNewCode',//合同编码规则,getNewCode可形成类似'D11050003华'的编码，留空可形成DH11-00002的编码
	//'htbmxg'=>false,//合同编码是否可以修改，默认不可修改流转单号，置为true则可修改流转单号
	'dbDSN' => array(
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'login'     => 'root',
        'password'  => '123456',
        'database'  => 'henglun'
    )
);
?>
