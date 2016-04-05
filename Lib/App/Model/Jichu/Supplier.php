<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Supplier extends TMIS_TableDataGateway {
	var $tableName = 'jichu_supplier';
	var $primaryKey = 'id';
	var $primaryName = 'compName';
	var $sortByKey = 'convert(trim(compName) USING gbk)';

    
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Jichu_SupplierTaitou',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier'
		)

	);

}
?>