<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_Plan2Gongxu extends TMIS_TableDataGateway {
	var $tableName = 'shengchan_plan2product_gongxu';
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