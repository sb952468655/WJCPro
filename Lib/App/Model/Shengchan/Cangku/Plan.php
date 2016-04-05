<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_Cangku_Plan extends TMIS_TableDataGateway {
	var $tableName = 'pisha_plan';
	var $primaryKey = 'id';

	var $hasMany = array (
		array(
			'tableClass' => 'Model_Shengchan_Cangku_Plan2Product',
			'foreignKey' => 'psPlanId',
			'mappingName' => 'Products',
		)
	);

	

}


?>