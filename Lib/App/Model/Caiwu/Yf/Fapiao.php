<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Caiwu_Yf_Fapiao extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_yf_fapiao';
	var $primaryKey = 'id';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Jichu_Supplier',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier',
		)
	);
	
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Caiwu_Yf_Fapiao2guozhang',
			'foreignKey' => 'fapiaoId',
			'mappingName' => 'Guozhang'
		)
	);
}

?>