<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_PlanTl extends TMIS_TableDataGateway {
	var $tableName = 'shengchan_plan_touliao';
	var $primaryKey = 'id';

	var $hasMany = array (
		array(
			'tableClass' => 'Model_Shengchan_Plan2Gongxu',
			'foreignKey' => 'touliaoId',
			'mappingName' => 'Plan2Gongxu',
		),
		array(
			'tableClass' => 'Model_Shengchan_Plan2Touliao',
			'foreignKey' => 'touliaoId',
			'mappingName' => 'Plan2Touliao',
		)
	);

	var $manyToMany = array(
		array(
			'tableClass' => 'Model_Shengchan_Plan2Product',
			'mappingName' => 'plan2proId',
			'joinTable' => 'shengchan_plan_touliao2product',
			'foreignKey' => 'touliaoId',
			'assocForeignKey' => 'plan2proId'
		)
	);

}


?>