<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_Plan extends TMIS_TableDataGateway {
	var $tableName = 'shengchan_plan';
	var $primaryKey = 'id';
	// var $primaryName = 'plan';

	var $hasMany = array (
		array(
			'tableClass' => 'Model_Shengchan_Plan2Product',
			'foreignKey' => 'planId',
			'mappingName' => 'Products',
		)
	);

}


?>