<?php
load_class('TMIS_Model_Cangku_Son');
class Model_Shengchan_Cangku_Chuku2Product extends TMIS_Model_Cangku_Son {
	var $tableName = 'cangku_chuku_son';
	var $primaryKey = 'id';

	//库存model标识符
	var $modelKucun = 'Model_Shengchan_Cangku_Kucun';
	//是否出库，如果是出库，数量新增时需要*-1
	var $isChuku = true;
	//子表记录中的主表映射名,用来取得主表记录
	var $mappingName = 'Ck';
	//日期字段,必须在主表中
	var $fldDate = 'chukuDate';
	//数量,金额字段,必须在子表中,且数量字段可以是多个
	var $fldCnt = array('cnt'=>'cnt','cntJian'=>'cntJian');
	var $fldMoney = array('money'=>'money');
	//其他需要复制到库存表中的字段，主要是汇总字段(分主从表,字段名必须一致)，也可能是数量字段（不参与库存计算)
	var $fldCopyMain = array('kind','type','kuweiId','isCheck','hzl');
	var $fldCopySon = array('productId','pihao','dengji','color','ganghao','supplierId');

	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Shengchan_Cangku_Chuku',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Ck',
		)/*,
		array(
			'tableClass' => 'Model_Jichu_Jiagonghu',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier',
		)*/
	);

	var $hasMany = array(
		array(
			'tableClass' => 'Model_Shengchan_Cangku_Madan',
			'foreignKey' => 'chuku2proId',
			'mappingName' => 'Madan',
			'linkRemove'=>false,
			'linkRemoveFillValue'=>0
		)
	);

}
?>