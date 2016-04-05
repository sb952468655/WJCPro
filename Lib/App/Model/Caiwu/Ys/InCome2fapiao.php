<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Caiwu_Ys_InCome2fapiao extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_ar_income2fapiao';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Caiwu_Ys_InCome',
			'foreignKey' => 'incomeId',
			'mappingName' => 'Income'
		),
		array(
			'tableClass' => 'Model_Caiwu_Ys_Fapiao',
			'foreignKey' => 'fapiaoId',
			'mappingName' => 'Fapiao'
		)
	);
}

?>