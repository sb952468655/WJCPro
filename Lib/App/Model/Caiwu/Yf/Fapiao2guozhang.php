<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Caiwu_Yf_Fapiao2guozhang extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_yf_fapiao2guozhang';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Caiwu_Yf_Guozhang',
			'foreignKey' => 'guozhangId',
			'mappingName' => 'Guozhang'
		),
		array(
			'tableClass' => 'Model_Caiwu_Yf_Fapiao',
			'foreignKey' => 'fapiaoId',
			'mappingName' => 'Fapiao'
		)
	);
}

?>