<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_Cangku_Ruku extends TMIS_TableDataGateway {
	var $tableName = 'cangku_ruku';
	var $primaryKey = 'id';

	var $hasMany = array (
		array(
			'tableClass' => 'Model_Shengchan_Cangku_Ruku2Product',
			'foreignKey' => 'rukuId',
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
			'tableClass' => 'Model_Jichu_Kuwei',
			'foreignKey' => 'kuweiId',
			'mappingName' => 'Kuwei',
		)
	);

}


?>