<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_Cangku_Chuku extends TMIS_TableDataGateway {
	var $tableName = 'cangku_chuku';
	var $primaryKey = 'id';

	var $hasMany = array (
		array(
			'tableClass' => 'Model_Shengchan_Cangku_Chuku2Product',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Products',
		)
	);

	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Jiagonghu',
			'foreignKey' => 'jiagonghuId',
			'mappingName' => 'Jgh',
		),
		array(
			'tableClass' => 'Model_Jichu_Department',
			'foreignKey' => 'departmentId',
			'mappingName' => 'Department',
		),
		array(
			'tableClass' => 'Model_Jichu_Kuwei',
			'foreignKey' => 'kuweiId',
			'mappingName' => 'Kuwei',
		)
	);

}


?>