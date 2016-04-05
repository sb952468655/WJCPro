<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Caiwu_Ys_Income2Guozhang extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_ar_income2guozhang';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Caiwu_Ys_InCome',
			'foreignKey' => 'incomeId',
			'mappingName' => 'Income'
		),
		array(
			'tableClass' => 'Model_Caiwu_Ys_Guozhang',
			'foreignKey' => 'guozhangId',
			'mappingName' => 'Guozhang'
		)
	);
}

?>