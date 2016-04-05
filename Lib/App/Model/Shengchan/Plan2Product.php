<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_Plan2Product extends TMIS_TableDataGateway {
	var $tableName = 'shengchan_plan2product';
	var $primaryKey = 'id';

	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Shengchan_Plan',
			'foreignKey' => 'planId',
			'mappingName' => 'Plan',
		),
		array(
			'tableClass' => 'Model_Jichu_Product',
			'foreignKey' => 'productId',
			'mappingName' => 'Product',
		),
	);
}


?>