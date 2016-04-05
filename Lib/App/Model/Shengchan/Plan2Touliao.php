<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_Plan2Touliao extends TMIS_TableDataGateway {
	var $tableName = 'shengchan_plan2product_touliao';
	var $primaryKey = 'id';

	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Shengchan_PlanTl',
			'foreignKey' => 'touliaoId',
			'mappingName' => 'Touliao',
		)
	);
}


?>