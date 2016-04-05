<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Shengchan_Cangku_Madan extends TMIS_TableDataGateway {
	var $tableName = 'cangku_madan';
	var $primaryKey = 'id';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Shengchan_Cangku_Ruku2Product',
			'foreignKey' => 'ruku2proId',
			'mappingName' => 'Ruku2pro'
		)
	);

}
?>