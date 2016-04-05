<?php
load_class('TMIS_TableDataGateway');
class Model_Caiwu_Feiyong extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_xianjin';
	var $primaryKey = 'id';
	//var $primaryName = 'itemName';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Jichu_Feiyong',
			'foreignKey' => 'itemId',
			'mappingName' => 'Item'
		)
	);

}
?>