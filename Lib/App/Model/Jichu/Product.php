<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Product extends TMIS_TableDataGateway {
	var $tableName = 'jichu_product';
	var $primaryKey = 'id';
	var $primaryName = 'proCode';

	var $hasMany = array (
		array(
			'tableClass' => 'Model_Jichu_ProductSon',
			'foreignKey' => 'proId',
			'mappingName' => 'Products',
		),
		array(
			'tableClass' => 'Model_Jichu_ProductGongxu',
			'foreignKey' => 'proId',
			'mappingName' => 'Gongxus',
		)
	);

}
?>