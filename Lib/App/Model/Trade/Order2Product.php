<?php
load_class('TMIS_TableDataGateway');
class Model_Trade_Order2Product extends TMIS_TableDataGateway {
	var $tableName = 'trade_order2product';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Product',
			'foreignKey' => 'productId',
			'mappingName' => 'Products'
		),
		array(
			'tableClass' => 'Model_Trade_Order',
			'foreignKey' => 'orderId',
			'mappingName' => 'Order'
		)
	);

	// 取得入库成品中某一车间, 某一原料的所有数量
	function getRukuYlCnt($ylId, $chejianId) {
		$initDate = '2009-4-1';		//设定期初日期
		$count = 0;					//本函数返回变量

		//找出含有$ylId的产品
		$modelProduct = FLEA::getSingleton('Model_Jichu_Product'); 
		$arrProId = $modelProduct->getArrProId($ylId);

		if (count($arrProId)>0) foreach($arrProId as & $v) {
			$condition[] = array('productId', $v['productId']);
			$condition[] = array('Ruku.chejianId', $chejianId);
			$condition[] = array('Ruku.rukuDate', $initDate, '>=');
			$rowset = $this->findAll($condition, null, null, "productId,cnt");
			if (count($rowset)>0) foreach($rowset as & $item) {
				$count += $item['cnt']*$v['ylCnt'];
			}
			$condition = array();
		}
		return $count;
	}

	// 取得入库成品中某一原料的所有数量
	function getRukuYlCntAll($ylId) {
		$initDate	= '2009-4-1';		//设定期初日期
		$count		= 0;				//本函数返回变量

		$modelProduct	= FLEA::getSingleton('Model_Jichu_Product'); 
		$arrProId		= $modelProduct->getArrProId($ylId);

		if (count($arrProId)>0) foreach($arrProId as & $v) {
			$condition[] = array('productId', $v['productId'], '=');
			$condition[] = array('Ruku.rukuDate', $initDate, '>=');
			$rowset = $this->findAll($condition, null, null, "productId, cnt");
			if (count($rowset)>0) foreach($rowset as & $item) {
				$count += $item['cnt']*$v['ylCnt'];
			}
			$condition = array();
		}
		return $count;
	}
}
?>