<?php
load_class('TMIS_TableDataGateway');
class Model_Trade_OrderFeiyong extends TMIS_TableDataGateway {
	var $tableName = 'trade_order_feiyong';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Trade_Order',
			'foreignKey' => 'orderId',
			'mappingName' => 'Order'
		)
	);

}
?>