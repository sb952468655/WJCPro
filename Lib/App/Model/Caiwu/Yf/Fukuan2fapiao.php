<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Caiwu_Yf_Fukuan2fapiao extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_yf_fukuan2fapiao';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Caiwu_Yf_Fukuan',
			'foreignKey' => 'fukuanId',
			'mappingName' => 'Fukuan'
		),
		array(
			'tableClass' => 'Model_Caiwu_Yf_Fapiao',
			'foreignKey' => 'fapiaoId',
			'mappingName' => 'Fapiao'
		)
	);
}

?>