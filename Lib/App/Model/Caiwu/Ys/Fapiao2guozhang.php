<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Caiwu_Ys_Fapiao2guozhang extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_ar_fapiao2guozhang';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Caiwu_Ys_Guozhang',
			'foreignKey' => 'guozhangId',
			'mappingName' => 'Guozhang'
		),
		array(
			'tableClass' => 'Model_Caiwu_Ys_Fapiao',
			'foreignKey' => 'fapiaoId',
			'mappingName' => 'Fapiao'
		)
	);
}

?>